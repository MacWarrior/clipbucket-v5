<?php 

	/**
	* File : Conversion Class
	* Description : ClipBucket conversion system fully depends on this class. All conversion related
	* processes pass through here like generating thumbs, extrating video meta, extracting
	* video qualities and other similar actions
	* @since : ClipBucket 2.8.1 January 17th, 2017
	* @author : Saqib Razzaq
	* @modified : { 17th January, 2017 } { Created file and added functions } { Saqib Razzaq }
	* @notice : File to be maintained
	*/

	class ffmpeg {

		# stores path for ffmepg binary file, used for basic conversion actions
		private $ffmpegPath = '';

		# stores path for ffprobe binary file, used for video meta extraction
		private $ffprobePath = '';

		# stores path for mediainfo, also used for video meta exraction
		private $mediainfoPath = '';

		# stores number of maximum allowed processes for ffmpeg
		private $maxProsessesAtOnce = '';

		# stores filename of video being currently being processed
		private $fileName = '';

		# stores directory of video file currently being processed
		private $fileDirectory = '';

		# stores directory where output (processed / converted) file is to be stored
		private $outputDirectory = '';

		# stores directory to save video conversion logs
		private $logsDir = LOGS_DIR;

		# stores name of file that should be used for dumping video conversion log
		private $logFile = '';

		# stores path to temporary directory where file stay before they are moved
		# either to conversion qeue or final destination
		private $tempDirectory = TEMP_DIR;

		# stores path to conversion lock file which is used to check if more processes
		# are allowed at a time or not
		public $ffmpegLock = '';

		# stores settings for generating video thumbs
		private $thumbsResSettings = '';

		# stores settings for 16:9 ratio conversion
		private $res169 = '';

		# stores settings for 4:3 ratio conversion
		private $resolution4_3 = '';

		# stores basic ffmpeg configurations for processing video
		private $ffmpegConfigs = '';

		/**
		* Action : Function that runs everytime class is initiated
		* Description : 
		* @param : { array } { $ffmpegParams } { an array of paramters }
		* @param : { string } { $ffmpegParams : fileName } { fileName of video to process }
		* @param : { string } { $ffmpegParams : fileDirectory } { Directory name of video to process }
		* @param : { string } { $ffmpegParams : outputDirectory } { Directory name where converted video is to be saved }
		* @param : { string } { $ffmpegParams : logFile } { file path to log file for dumping conversion logs }
		*/

		function __construct($ffmpegParams) {
			$this->ffmpegPath = get_binaries('ffmpeg');
			$this->ffprobePath = get_binaries('ffprobe_path');
			$this->mediainfoPath = get_binaries('media_info');
			$this->maxProsessesAtOnce = config('max_conversion');
			$this->fileName = $ffmpegParams['fileName'];
			$this->fileDirectory = $ffmpegParams['fileDirectory'];
			$this->outputDirectory = $ffmpegParams['outputDirectory'];
			$this->logFile = $ffmpegParams['logFile'];

			# Set thumb resoloution settings
			$this->thumbsResSettings = array(
				"original" => "original",
				'105' => array('168','105'),
				'260' => array('416','260'),
				'320' => array('632','395'),
				'480' => array('768','432')
				);

			# Set 16:9 ratio conversion settings
			$this->res169 = array(
				'240' => array('428','240'),
				'360' => array('640','360'),
				'480' => array('854','480'),
				'720' => array('1280','720'),
				'1080' => array('1920','1080'),
				);

			# Set 4:3 ratio conversion settings
			$this->resolution4_3 = array(
				'240' => array('428','240'),
				'360' => array('640','360'),
				'480' => array('854','480'),
				'720' => array('1280','720'),
				'1080' => array('1920','1080'),
				);

			# Set basic ffmpeg configurations
			$this->ffmpegConfigs = array(
				'use_video_rate' => true,
				'use_video_bit_rate' => true,
				'use_audio_rate' => true,
				'use_audio_bit_rate' => true,
				'use_audio_codec' => true,
				'use_video_codec' => true,
				'format' => 'mp4',
				'videoCodec'=> config('video_codec'),
				'audioCodec'=> config('audio_codec'),
				'audioRate'=> config("srate"),
				'audioBitrate'=> config("sbrate"),
				'videoRate'=> config("vrate"),
				'videoBitrate'=> config("vbrate"),
				'videoBitrateHd'=> config("vbrate_hd"),
				'normalRes' => config('normal_resolution'),
				'highRes' => config('high_resolution'),
				'maxVideoDuration' => config('max_video_duration'),
				'resize'=>'max',
				'outputPath' => $this->outputDirectory,
				'cbComboRes' => config('cb_combo_res'),
				'gen240' => config('gen_240'),
				'gen360' => config('gen_360'),
				'gen480' => config('gen_480'),
				'gen720' => config('gen_720'),
				'gen1080' => config('gen_1080')
			);
		}

		/**
		* Action : Execute a command and return output 
		* Description : Its better to keep shell_exec at one place instead pulling string everywhere
		* @param : { string } { $command } { command to run }
		* @author : Saqib Razzaq
		* @since : 17th January, 2017
		*
		* @return : { mixed } { output of command ran }
		*/

		private function executeCommand($command) {
			return shell_exec($command);
		}

		/**
		* Action : Parse required meta details of a video
		* Description : Conversion system can't proceed to do anything without first properly
		* knowing what kind of video it is dealing with. It is used to ensures that video resoloutions are 
		* extracted properly, thumbs positioning is proper, video qualities are legit etc.
		* If we bypass this information, we can end up with unexpected outputs. For example, you upload
		* a video of 240p and system will try to convert it to 1080 which means? You guessed it, DISASTER!
		* Hence, we extract details and then do video processing accordingly
		* @param : { boolean } { $filePath } { false by default, file to extract information out of }
		* @param : { boolean } { $durationOnly } { false by default, returns only duration of video }
		* @author : Saqib Razzaq
		* @since : 17th January, 2017
		*
		* @return : { array } { $responseData } { an array with response according to params }
		*/

		public function extractVideoDetails($filePath = false, $durationOnly = false) {
			
			if ($filePath) {
				$fileFullPath = $filePath;
			} else {
				$fileFullPath = $this->fileDirectory.'/'.$this->fileName;
			}

			if (file_exists($fileFullPath)) {
				$responseData = array();
				if ($durationOnly) {
					$mediainfoDurationCommand = $this->mediainfoPath."   '--Inform=General;%Duration%'  '". $fileFullPath."' 2>&1 ";
					$duration = $responseData['duration'] = round($this->executeCommand($mediainfoDurationCommand) / 1000,2);
					return $responseData;
				} else {
					$responseData['format'] = 'N/A';
					$responseData['duration'] = 'N/A';
					$responseData['size'] = 'N/A';
					$responseData['bitrate'] = 'N/A';
					$responseData['video_width'] = 'N/A';
					$responseData['video_height'] = 'N/A';
					$responseData['video_wh_ratio'] = 'N/A';
					$responseData['video_codec'] = 'N/A';
					$responseData['video_rate'] = 'N/A';
					$responseData['video_bitrate'] = 'N/A';
					$responseData['video_color'] = 'N/A';
					$responseData['audio_codec'] = 'N/A';
					$responseData['audio_bitrate'] = 'N/A';
					$responseData['audio_rate'] = 'N/A';
					$responseData['audio_channels'] = 'N/A';
					$responseData['path'] = $file_path;

					$ffprobeMetaCommand = $this->ffprobePath;
					$ffprobeMetaCommand .= " -v quiet -print_format json -show_format -show_streams ";
					$ffprobeMetaCommand .= " '$fileFullPath' ";
					$ffprobeMetaData = $this->executeCommand($ffprobeMetaCommand);
					$videoMetaCleaned = json_decode($ffprobeMetaData);

					$firstCodecType = $videoMetaCleaned->streams[0]->codec_type;
					$secondCodecType = $videoMetaCleaned->streams[1]->codec_type;

					$$firstCodecType = $videoMetaCleaned->streams[0];
					$$secondCodecType = $videoMetaCleaned->streams[1];

					$responseData['format'] = $videoMetaCleaned->format->format_name;
					$responseData['duration'] = (float) round($video->duration,2);

					$responseData['bitrate'] = (int) $videoMetaCleaned->format->bit_rate;
					$responseData['videoBitrate'] = (int) $video->bit_rate;
					$responseData['videoWidth'] = (int) $video->width;
					$responseData['videoHeight'] = (int) $video->height;

					if($video->height) {
						$responseData['videoWhRatio'] = (int) $video->width / (int) $video->height;
					}

					$responseData['videoCodec'] = $video->codec_name;
					$responseData['videoRate'] = $video->r_frame_rate;
					$responseData['size'] = filesize($fileFullPath);
					$responseData['audioCodec'] = $audio->codec_name;;
					$responseData['audioBitrate'] = (int) $audio->bit_rate;;
					$responseData['audioRate'] = (int) $audio->sample_rate;;
					$responseData['audioChannels'] = (float) $audio->channels;
					$responseData['rotation'] = (float) $video->tags->rotate;

					if(!$responseData['duration'])	{
						$mediainfoDurationCommand = $this->mediainfoPath."   '--Inform=General;%Duration%'  '". $fileFullPath."' 2>&1 ";
						$duration = $responseData['duration'] = round($this->executeCommand($mediainfoDurationCommand) / 1000,2);
					}

					$videoRate = explode('/',$responseData['video_rate']);
					$int_1_videoRate = (int) $videoRate[0];
					$int_2_videoRate = (int) $videoRate[1];
					
					$mediainfoMetaCommand = $this->mediainfoPath . "   '--Inform=Video;'  ". $fileFullPath;
					$mediainfoMetaData = $this->executeCommand($mediainfoMetaCommand);

					$needleStart = "Original height";
					$needleEnd = "pixels"; 
					$originalHeight = find_string($needleStart,$needleEnd,$mediainfoMetaData);
					$originalHeight[1] = str_replace(' ', '', $originalHeight[1]);

					if (!empty($originalHeight) && $originalHeight != false) {
						$origHeight = trim($originalHeight[1]);
						$origHeight = (int) $origHeight;
						if($origHeight!=0 && !empty($origHeight)) {
							$responseData['videoHeight'] = $origHeight;
						}
					}

					$needleStart = "Original width";
					$needleEnd = "pixels"; 
					$originalWidth = find_string($needleStart,$needleEnd,$mediainfoMetaData);
					$originalWidth[1] = str_replace(' ', '', $originalWidth[1]);

					if(!empty($originalWidth) && $originalWidth != false) {
						$origWidth = trim($originalWidth[1]);
						$origWidth = (int)$origWidth;
						if($origWidth > 0 && !empty($origWidth)) {
							$responseData['videoWidth'] = $origWidth;
						}
					}

					if($int_2_video_rate > 0 ) {
						$responseData['videoRate'] = $int_1_videoRate / $int_2_videoRate;
					}
				}

				return $responseData;
			}
		}
	}


?>