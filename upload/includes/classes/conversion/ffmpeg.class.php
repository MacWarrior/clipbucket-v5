<?php

define('FFMPEG_BINARY', get_binaries('ffmpeg'));
define('MEDIAINFO_BINARY', get_binaries('media_info'));
define('FFPROBE', get_binaries('ffprobe_path'));
define('thumbs_number',config('num_thumbs'));
define('PROCESSESS_AT_ONCE',config('max_conversion'));

class FFMpeg
{
	// Start public variables declaration
	public $defaultOptions = array();
	public $num = thumbs_number;
	public $reconvert = false;
	public $ffMpegPath = FFMPEG_BINARY;
	public $log = '';
	public $logs = '';
	public $file_name = '';
	public $ratio = '';
	public $raw_path = '';
	public $audio_track = false;
	public $file_directory = '';
	public $thumbs_res_settings = array(
        'original' => 'original',
        '105' => array('168','105'),
        '260' => array('416','260'),
        '320' => array('632','395'),
        '480' => array('768','432')
    );
	// End public variables declaration

	// Start private variables declaration
	private $options = array();
	private $videosDirPath = VIDEOS_DIR;
	// End private variables declaration

	public function __construct($options = false, $log = false)
	{
		$this->setDefaults();
		if($options && !empty($options))
		{
			$this->setOptions($options);
		} else {
			$this->setOptions($this->defaultOptions);
		}
		if($log){
			$this->log = $log;
        }
	}

	function exec( $cmd )
	{
		# use bash to execute the command
		# add common locations for bash to the PATH
		# this should work in virtually any *nix/BSD/Linux server on the planet
		# assuming we have execute permission
		//$cmd = "PATH=\$PATH:/bin:/usr/bin:/usr/local/bin bash -c \"$cmd\" ";
		return shell_exec($cmd);
	}

    /**
     * Function used to get file information using FFPROBE
     *
     * @param null|string $file_path
     *
     * @return mixed
     */
	function get_file_info($file_path=NULL)
	{
		if(!$file_path){
			$file_path = $this->input_file;
        }

		$info['format']              = 'N/A';
		$info['duration']            = 'N/A';
		$info['size']                = 'N/A';
		$info['bitrate']             = 'N/A';
		$info['video_width']         = 'N/A';
		$info['video_height']        = 'N/A';
		$info['video_wh_ratio']      = 'N/A';
		$info['video_codec']         = 'N/A';
		$info['video_rate']          = 'N/A';
		$info['video_bitrate']       = 'N/A';
		$info['video_color']         = 'N/A';
		$info['audio_codec']         = 'N/A';
		$info['audio_bitrate']       = 'N/A';
		$info['audio_rate']          = 'N/A';
		$info['audio_channels']      = 'N/A';
		$info['bits_per_raw_sample'] = 'N/A';
		$info['path']           = $file_path;

		$cmd = FFPROBE. " -v quiet -print_format json -show_format -show_streams '".$file_path."' ";
		$output = shell_output($cmd);
		$output = preg_replace('/([a-zA-Z 0-9\r\n]+){/', '{', $output, 1);

		$data = json_decode($output,true);

		$video = NULL;
		$audio = NULL;
		foreach($data['streams'] as $stream) {
			if( $stream['codec_type'] == 'video' && empty($video) ) {
				$video = $stream;
				continue;
			}

			if( $stream['codec_type'] == 'audio' && empty($audio) ) {
				$audio = $stream;
				continue;
			}

			if( !empty($video) && !empty($audio) ){
				break;
            }
		}

		$info['format']         = $data['format']['format_name'];
		$info['duration']       = (float) round($video['duration'],2);

		$info['bitrate']        = (int) $data['format']['bit_rate'];
		$info['video_bitrate']  = (int) $video['bit_rate'];
		$info['video_width']    = (int) $video['width'];
		$info['video_height']   = (int) $video['height'];
		$info['bits_per_raw_sample'] = (int) $video['bits_per_raw_sample'];

		if($video['height']){
			$info['video_wh_ratio'] = (int) $video['width'] / (int) $video['height'];
        }
		$info['video_codec']    = $video['codec_name'];
		$info['video_rate']     = $video['r_frame_rate'];
		$info['size']           = filesize($file_path);
		$info['audio_codec']    = $audio['codec_name'];
		$info['audio_bitrate']  = (int) $audio['bit_rate'];
		$info['audio_rate']     = (int) $audio['sample_rate'];
		$info['audio_channels'] = (float) $audio['channels'];
		$info['rotation']       = (float) $video['tags']['rotate'];

		if(!$info['duration'] || 1) {
			$CMD = MEDIAINFO_BINARY . " '--Inform=General;%Duration%'  '". $file_path."' 2>&1 ";
			$info['duration'] = round(shell_output( $CMD )/1000,2);
		}

		$this->raw_info = $info;
		$video_rate = explode('/',$info['video_rate']);
		$int_1_video_rate = (int)$video_rate[0];
		$int_2_video_rate = (int)$video_rate[1];

		$CMD = MEDIAINFO_BINARY . " '--Inform=Video;' ". $file_path;

		$results = shell_output($CMD);
		$needle_start = 'Original height';
		$needle_end = 'pixels';
		$original_height = find_string($needle_start,$needle_end,$results);
		$original_height[1] = str_replace(' ', '', $original_height[1]);
		if(!empty($original_height)&&$original_height!=false)
		{
			$o_height = trim($original_height[1]);
			$o_height = (int)$o_height;
			if($o_height!=0&&!empty($o_height))
			{
				$info['video_height'] = $o_height;
			}
		}
		$needle_start = 'Original width';
		$needle_end = 'pixels';
		$original_width = find_string($needle_start,$needle_end,$results);
		$original_width[1] = str_replace(' ', '', $original_width[1]);
		if(!empty($original_width) && $original_width!=false)
		{
			$o_width = trim($original_width[1]);
			$o_width = (int)$o_width;
			if($o_width!=0 && !empty($o_width)) {
				$info['video_width'] = $o_width;
			}
		}
		
		if($int_2_video_rate!=0) {
			$info['video_rate'] = $int_1_video_rate/$int_2_video_rate;
		}
		return $info;
	}

	public function setOptions($options = array())
	{
		if(!empty($options)) {
			if(is_array($options)) {
				foreach ($options as $key => $value) {
					if(isset($this->defaultOptions[$key]) && !empty($value)){
						$this->options[$key] = $value;
					}
				}
			} else {
				$this->options[0] = $options;
			}
		}
	}

	function log($name,$value)
	{
		$this->log .= $name.' : '.$value."\r\n";
	}
	
	/**
	 * Function used to start log
	 */
	function start_log()
	{
		$TemplogData = 'Started on '.NOW().' - '.date('Y M d')."\n\n";
		$TemplogData .= "Checking File...\n";
		$TemplogData .= "File : {$this->input_file}";
		$this->log->writeLine('Starting Conversion', $TemplogData, true);
	}
	
	/**
	 * Function used to log video info
	 */
	function log_file_info()
	{
		$details = $this->input_details;
		$configLog = '';
		if(is_array($details)) {
			foreach($details as $name => $value) {
				$configLog .= "<strong>{$name}</strong> : {$value}\n";
			}
		} else {
			$configLog = "Unknown file details - Unable to get video details using FFMPEG \n";
		}

		$this->log->writeLine('Preparing file...', $configLog, true);
	}

	/**
	 * Function log outpuit file details
	 */
	function log_ouput_file_info()
	{
		$details = $this->output_details;
		$configLog = '';
		if(is_array($details)) {
			foreach($details as $name => $value) {
				$configLog .= "<strong>{$name}</strong> : {$value}\n";
			}
		} else {
			$configLog = "Unknown file details - Unable to get video details using FFMPEG \n";
		}

		$this->log->writeLine('OutPut Details', $configLog, true);
	}

	function time_check()
	{
		$time = microtime();
		$time = explode(' ',$time);
		return $time[1]+$time[0];
	}
	
	/**
	 * Function used to start timing
	 */
	function start_time_check()
	{
		$this->start_time = $this->time_check();
	}
	
	/**
	 * Function used to end timing
	 */
	function end_time_check()
	{
		$this->end_time = $this->time_check();
	}
	
	/** 
	 * Function used to check total time 
	 */
	function total_time()
	{
		$this->total_time = round(($this->end_time-$this->start_time),4);
	}
	
	function getClosest($search, $arr) 
	{
		$closest = null;
		foreach ($arr as $item) {
			if($closest === null || abs($search - $closest) > abs($item - $search)) {
				$closest = $item;
			}
		}
		return $closest;
	}

	/**
	 * @Reason : this function is used to rearrange required resolution for conversion
	 *
	 * @params : { resolutions (Array) }
	 *
	 * @date : 13-12-2016
	 * return : refined resolution array
	 *
	 * @param $resolutions
	 *
	 * @return bool|array
	 */
	function reindex_required_resolutions($resolutions)
	{
		$original_video_height = $this->input_details['video_height'];

		$input_video_height = $this->getClosest($original_video_height, array_keys($resolutions));
        $final_res = [];
        $final_res[$input_video_height] = $resolutions[$input_video_height];

		foreach ($resolutions as $key => $value)
		{
			$video_height = (int)$key;
			if($input_video_height != $video_height){
				$final_res[$video_height] = $value;	
			}
		}

		if ( !empty($final_res) ){
			return $final_res;
        }
		return false;
	}

	function isLocked($num=1): bool
    {
		for($i=0;$i<$num;$i++)
		{
			$conv_file = TEMP_DIR.'/conv_lock'.$i.'.loc';
			if(!file_exists($conv_file))
			{
				$this->lock_file = $conv_file;
				$file = fopen($conv_file,'w+');
				fwrite($file,'converting..');
				fclose($file);
				return false;
			}
		}
		return true;
	}

	function ClipBucket()
	{
		$conv_file = TEMP_DIR.'/conv_lock.loc';

		//We will now add a loop that will check weather
		while( true )
		{
			$use_crons = config('use_crons');
			if( !$this->isLocked(PROCESSESS_AT_ONCE) || $use_crons == 'yes' )
			{
				if( $use_crons == 'no' )
				{
					//Lets make a file
					$file = fopen($conv_file,'w+');
					fwrite($file,'converting..');
					fclose($file);
				}

				$this->start_time_check();
				$this->start_log();
				$this->prepare();
				
				$ratio = (float)substr($this->input_details['video_wh_ratio'], 0, 7);
				
				$max_duration = config('max_video_duration') * 60;

				if( $this->input_details['duration'] > $max_duration )
				{
					$max_duration_seconds = $max_duration / 60; 
					$log = 'Video duration was '.$this->input_details['duration']." minutes and Max video duration is {$max_duration_seconds} minutes, Therefore Video cancelled\n";
					$log .= "Conversion_status : failed\n";
					$log .= "Failed Reason : Max Duration Configurations\n";
					$this->log->writeLine('Max Duration configs', $log, true);
					$this->failed_reason = 'max_duration';
					break;
				}

				$log = '';
				try {
					$thumbs_settings = $this->thumbs_res_settings;
					foreach( $thumbs_settings as $key => $thumbs_size )
					{
						$height_setting = $thumbs_size[1];
						$width_setting = $thumbs_size[0];
						$dimension_setting = $width_setting.'x'.$height_setting;
						if( $key == 'original' ) {
							$dimension_setting = $key;
							$dim_identifier = $key;	
						} else {
							$dim_identifier = $width_setting.'x'.$height_setting;	
						}
						$thumbs_settings['vid_file'] = $this->input_file;
						$thumbs_settings['duration'] = $this->input_details['duration'];
						$thumbs_settings['num']      = thumbs_number;
						$thumbs_settings['dim']      = $dimension_setting;
						$thumbs_settings['size_tag'] = $dim_identifier;
						$this->generateThumbs($thumbs_settings);
					}
					
				} catch(Exception $e) {
					$log .= "\r\n Error Occured : ".$e->getMessage()."\r\n";
				}

				$log .= "\r\n ====== End : Thumbs Generation ======= \r\n";
				$this->log->writeLine('Thumbs Generation', $log, true);

                $this->options['format'] = 'mp4';
                $orig_file = $this->input_file;

                if( config('stay_mp4') == 'yes' ){
                    $output_directory = $this->videosDirPath.DIRECTORY_SEPARATOR.$this->options['outputPath'];
                    if(!is_dir($output_directory)){
                        mkdir($output_directory,0755, true);
                    }

                    $filepath_destination = $output_directory.$this->file_name.'.mp4';
                    copy($orig_file,$filepath_destination);

                    $this->output_file = $filepath_destination;
                } else {
                    global $myquery;
                    $resolutions = $this->reindex_required_resolutions($myquery->getEnabledVideoResolutions());

                    $this->ratio = $ratio;
                    foreach( $resolutions as $key => $value )
                    {
                        $video_height = (int)$key;
                        $video_width  = (int)$value;

                        // This option allow video with a 1% lower resolution to be included in the superior resolution
                        // For example : 1900x800 will be allowed in 1080p resolution
                        if( config('allow_conversion_1_percent') == 'yes' ){
                            $video_height_test = floor($video_height*0.99);
                            $video_width_test = floor($video_width*0.99);
                        } else {
                            $video_height_test = $video_height;
                            $video_width_test = $video_width;
                        }

                        // Here we must check width and height to be able to import other formats than 16/9 (For example : 1920x800, 1800x1080, ...)
                        if( $this->input_details['video_width'] >= $video_width_test || $this->input_details['video_height'] >= $video_height_test )
                        {
                            $more_res['video_width']  = $video_width;
                            $more_res['video_height'] = $video_height;
                            $more_res['height']		  = $video_height;
                            $this->convert(NULL, false, $more_res);
                        }
                    }
                }

                $this->end_time_check();
                $this->total_time();

                $log = '';

                //Copying File To Original Folder
                if( $this->keep_original == 'yes' )
                {
                    $log .= "Copy File to original Folder\r\n";
                    if( copy($this->input_file, $this->original_output_path) ){
                        $log .= "File Copied to original Folder...\r\n";
                    } else {
                        $log .= "Unable to copy file to original folder...\r\n";
                    }
                }

                $log .= 'Time Took : '.$this->total_time.' seconds'."\r\n";

                if(file_exists($this->output_file) && filesize($this->output_file) > 0) {
                    $log .= 'Conversion_status : completed';
                } else {
                    $log .= 'Conversion_status : failed';
                }

                $this->log->writeLine('Conversion Completed', $log, true);
                break;
			}

			// Prevent video_convert action to use 100% cpu while waiting for queued videos to end conversion
			sleep(5);
		}
	}

	private function executeCommand($command = false)
	{
		// the last 2>&1 is for forcing the shell_exec to return the output 
		if($command){
			return shell_exec($command . ' 2>&1');
        }
		return false;
	}

	private function setDefaults()
	{
		$audio_codecs = get_ffmpeg_codecs('audio');
		$video_codecs = get_ffmpeg_codecs('video');

		$this->defaultOptions = array(
			'format' => 'mp4',
			'video_codec'=> $video_codecs[0],
			'audio_codec'=> $audio_codecs[0],
			'audio_rate'=> '22050',
			'audio_bitrate'=> '128000',
			'video_rate'=> '25',
			'video_bitrate'=> '300000',
			'video_bitrate_hd'=> '500000',
			'normal_res' => false,
			'high_res' => false,
			'max_video_duration' => false,
			'resize'=>'max',
			'outputPath' => false,
			'use_video_rate' => false,
			'use_video_bit_rate' => false,
			'use_audio_rate' => false,
			'use_audio_bit_rate' => false,
			'use_audio_codec' => false,
			'use_video_codec' => false,
		);
	}

	function ffmpeg($file)
	{
		$this->ffmpeg = FFMPEG_BINARY;
		$this->input_file = $file;
	}

	function calculate_size_padding( $parameters, $source_info, & $width, & $height, & $ratio, & $pad_top, & $pad_bottom, & $pad_left, & $pad_right )	
	{
		$p = $parameters;
		$i = $source_info;

		switch( $p['resize'] )
		{
			# don't resize, use same size as source, and aspect ratio
			# WARNING: some codec will NOT preserve the aspect ratio
			case 'no':
				$width      = $i['video_width'];
				$height     = $i['video_height'];
				$ratio      = $i['video_wh_ratio'];
				$pad_top    = 0;
				$pad_bottom = 0;
				$pad_left   = 0;
				$pad_right  = 0;
				break;
			# resize to parameters width X height, use same aspect ratio
			# WARNING: some codec will NOT preserve the aspect ratio
			case 'WxH':
				$width  = $p['video_width'];
				$height = $p['video_height'];
				$ratio  = $i['video_wh_ratio'];
				$pad_top    = 0;
				$pad_bottom = 0;
				$pad_left   = 0;
				$pad_right  = 0;
				break;
			# make pixel square
			# reduce video size if bigger than p[width] X p[height]
			# and preserve aspect ratio
			case 'max':
				$width        = (float)$i['video_width'];
				$height       = (float)$i['video_height'];
				$ratio        = (float)$i['video_wh_ratio'];
				$max_width    = (float)$p['video_width'];
				$max_height   = (float)$p['video_height'];

				# make pixels square
				if( $ratio > 1.0 )
					$width = $height * $ratio;
				else
					$height = @$width / $ratio;

				# reduce width
				if( $width > $max_width ) {
					$r       = $max_width / $width;
					$width  *= $r;
					$height *= $r;
				}

				# reduce height
				if( $height > $max_height ) {
					$r       = $max_height / $height;
					$width  *= $r;
					$height *= $r;
				}

				# make size even (required by many codecs)
				$width  = (integer)( ($width  + 1 ) / 2 ) * 2;
				$height = (integer)( ($height + 1 ) / 2 ) * 2;
				# no padding
				$pad_top    = 0;
				$pad_bottom = 0;
				$pad_left   = 0;
				$pad_right  = 0;
				break;
			# make pixel square
			# resize video to fit inside p[width] X p[height]
			# add padding and preserve aspect ratio
			case 'fit':
				# values need to be multiples of 2 in the end so
				# divide width and height by 2 to do the calculation
				# then multiply by 2 in the end
				$ratio        = (float)$i['video_wh_ratio'];
				$width        = (float)$i['video_width'   ] / 2;
				$height       = (float)$i['video_height'  ] / 2;
				$trt_width    = (float)$p['video_width'   ] / 2;
				$trt_height   = (float)$p['video_height'  ] / 2;

				# make pixels square
				if( $ratio > 1.0 ){
					$width = $height * $ratio;
                } else {
					$height = $width / $ratio;
                }
				
				# calculate size to fit
				$ratio_w = $trt_width  / $width;
				$ratio_h = $trt_height / $height;

				if( $ratio_h > $ratio_w ) {
					$width  = (integer)$trt_width;
					$height = (integer)($width / $ratio);
				} else {
					$height = (integer)$trt_height;
					$width  = (integer)($height * $ratio);
				}

				# calculate padding
				$pad_top    = (integer)(($trt_height - $height + 1) / 2);
				$pad_left   = (integer)(($trt_width  - $width  + 1) / 2);
				$pad_bottom = (integer)($trt_height  - $height - $pad_top );
				$pad_right  = (integer)($trt_width   - $width  - $pad_left);

				# multiply by 2 to undo division and get multiples of 2
				$width      *= 2;
				$height     *= 2;
				$pad_top    *= 2;
				$pad_left   *= 2;
				$pad_bottom *= 2;
				$pad_right  *= 2;
				break;
		}
	}

	/**
	 * Function used to convert video
	 *
	 * @param null $file
	 * @param bool $for_iphone
	 * @param null $more_res
	 */
	function convert($file=NULL,$for_iphone=false,$more_res=NULL)
	{
		global $width, $height;

		$TemplogData = '';
		
		$ratio = $this->ratio;
		if($file){
			$this->input_file = $file;
        }

		$p = $this->options;
		$i = $this->input_details;

		$opt_av = '';
		# Prepare the ffmpeg command to execute
		if( isset($p['extra_options']) ){
			$opt_av .= " -y {$p['extra_options']}";
        }

		if( $this->reconvert ){
			$opt_av .= ' -y';
        }

		# file format
		if( isset($p['format']) ){
			$opt_av .= " -f {$p['format']}";
        }

		$opt_av .= ' -movflags faststart';

		# Selecting audio track
        $video_track_id = self::get_media_stream_id('video', $this->input_file);
		if( $this->audio_track && is_numeric($this->audio_track) )
		{
			$opt_av .= ' -map 0:'.$video_track_id.' -map 0:'.($this->audio_track);
		} else {
            $opt_av .= ' -map 0:'.$video_track_id;

            $audio_tracks = self::get_media_stream_id('audio', $this->input_file);
            foreach($audio_tracks as $track_id){
                $opt_av .= ' -map 0:'.$track_id;
            }
        }

		if( $p['use_video_codec'] )
		{
			# video codec
			if( isset($p['video_codec']) ){
				$opt_av .= ' -vcodec '.$p['video_codec'];
            } else if( isset($i['video_codec']) ){
				$opt_av .= ' -vcodec '.$i['video_codec'];
            }

			if( $p['video_codec'] == 'libx264' )
			{
				if( $p['normal_quality'] != 'hq' ){
					$opt_av .= ' -preset medium';
                } else {
					$opt_av .= ' -preset slow -crf 26';
                }
			}
		}

		// Prevent start_time to be negative
		$opt_av .= ' -start_at_zero';

		# video rate
		if($p['use_video_rate'])
		{
			if(isset($p['video_rate'])){
				$vrate = $p['video_rate'];
            } else if(isset($i['video_rate'])) {
				$vrate = $i['video_rate'];
            }

			if(isset($p['video_max_rate']) && !empty($vrate)) {
				$vrate = min($p['video_max_rate'], $vrate);
            }

			if(!empty($vrate)) {
				$opt_av .= " -r $vrate ";
            }
		}

		# video bitrate
		if($p['use_video_bit_rate'])
		{
			if(isset($p['video_bitrate'])){
				$vbrate = $p['video_bitrate'];
            } elseif(isset($i['video_bitrate'])) {
				$vbrate = $i['video_bitrate'];
            }

			if(!empty($vbrate)){
                global $myquery;
				$vbrate = min($myquery->getVideoResolutionBitrateFromHeight($more_res['height']), $vbrate);
            }

			if(!empty($vbrate)){
				$opt_av .= ' -vb '.$vbrate.' ';
            }
		}

		# video size, aspect and padding
		
		#create all possible resolutions of selected video
		if($more_res!=NULL)
		{
			$p['resize'] = 'fit';
			$i['video_width']  = $more_res['video_width'];
			$i['video_height'] = $more_res['video_height'];

			$opt_av .= ' -s '.$more_res['video_width'].'x'.$more_res['video_height']." -aspect $ratio ";
		} else {
			$this->calculate_size_padding( $p, $i );
			$opt_av .= " -s {$width}x{$height} -aspect $ratio ";
		}

		# audio codec, rate and bitrate
		if($p['use_audio_codec'])
		{
			if(!empty($p['audio_codec']) && $p['audio_codec'] != 'None')
			{
				$codecs = get_ffmpeg_codecs('audio');
				if( !in_array($p['audio_codec'], $codecs) ){
					$p['audio_codec'] = $codecs[0];
                }
				$opt_av .= " -acodec {$p['audio_codec']}";
			}
		}

		// Fix for ChromeCast : Forcing stereo mode
		if( config('chromecast_fix') ){
			$opt_av .= ' -ac 2';
        }

        // Fix for browsers compatibility : yuv420p10le seems to be working only on Chrome like browsers
        if( config('force_8bits') ){
            $opt_av .= ' -pix_fmt yuv420p';
        }

        // Fix rare video conversion fail
        $opt_av .= ' -max_muxing_queue_size 1024';

		# audio bitrate
		if($p['use_audio_bit_rate'])
		{
			if(isset($p['audio_bitrate'])){
				$abrate = $p['audio_bitrate'];
            } elseif(isset($i['audio_bitrate'])) {
				$abrate = $i['audio_bitrate'];
            }

			if(!empty($abrate)) {
				$abrate_cmd = ' -ab '.$abrate;
				$opt_av .= $abrate_cmd;
			}
		}
		
		# audio bitrate
		if($p['use_audio_rate'])
		{
			$option_ar = false;
			if(isset($p['audio_rate'])){
				$option_ar = $p['audio_rate'];
            }

			$file_ar = false;
			if(isset($i['audio_rate']) && is_numeric($i['audio_rate'])){
				$file_ar = $i['audio_rate'];
            }

			$arate = false;
			if( $option_ar && $file_ar ) {
				$arate = min($option_ar, $file_ar);
			} else if( $option_ar ) {
				$arate = $option_ar;
			} else if( $file_ar ) {
				$arate = $file_ar;
			}

			if( $arate ){
				$opt_av .=" -ar $arate ";
            }
		}

		if ($i['rotation'] != 0 )
		{
			if ($i['video_wh_ratio'] >= 1.6){
				$opt_av .= " -vf pad='ih*16/9:ih:(ow-iw)/2:(oh-ih)/2' ";
			} else {
				$opt_av .= " -vf pad='ih*4/3:ih:(ow-iw)/2:(oh-ih)/2' ";
			}
		}

		$tmp_file = time().RandomString(5).'.tmp';

		if(!$for_iphone)
		{
			$TemplogData .= "\r\nConverting Video file ".$more_res['height'].' @ '.date('Y-m-d H:i:s')." \r\n";
			if($more_res==NULL){
				echo 'here';
			} else {
                $command  = $this->ffmpeg.' -i '.$this->input_file." $opt_av ".$this->raw_path.'-'.$more_res['height'].'.mp4 2> '.TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file;

                $video_dir = VIDEOS_DIR.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR;
                if(!is_dir($video_dir)){
                    mkdir($video_dir,0755, true);
                }

                $output = $this->exec($command);
			}

			if(file_exists(TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file)){
				$output = $output ? $output : join('', file(TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file));
				unlink(TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file);
			}

			if(file_exists($this->raw_path.'-'.$more_res['height'].'.mp4') && filesize($this->raw_path.'-'.$more_res['height'].'.mp4')>0)
			{
				$this->has_resolutions = 'yes';
				$this->video_files[] = $more_res['height'];
				$TemplogData .="\r\nFiles resolution : ".$more_res['height']." \r\n";
			} else {
				$TemplogData .="\r\n\r\nFile doesn't exist. Path: ".$this->raw_path.'-'.$more_res['height'].".mp4 \r\n\r\n";
			}

			$this->output_file = $this->raw_path.'-'.$more_res['height'].'.mp4';
			  
			if($more_res!=NULL)
			{
				$TemplogData .= "\r\n\r\n== Conversion Command == \r\n\r\n";
				$TemplogData .= $command;

				if( DEVELOPMENT_MODE ) {
					$TemplogData .= "\r\n\r\n== Conversion OutPut == \r\n\r\n";
					$TemplogData .= $output;
				}
			}
		}

		$TemplogData .="\r\n\r\nEnd resolutions @ ".date('Y-m-d H:i:s')."\r\n\r\n";
		$this->log->writeLine('Conversion Ouput', $TemplogData, true);

		$this->output_details = $this->get_file_info($this->output_file);
		$this->log_ouput_file_info();
	}

	/**
	 * Prepare file to be converted
	 * this will first get info of the file
	 * and enter its info into database
	 *
	 * @param null $file
	 */
	function prepare($file=NULL)
	{
		if($file){
			$this->input_file = $file;
        }

		if(!file_exists($this->input_file)){
			$this->input_file = TEMP_DIR.DIRECTORY_SEPARATOR.$this->input_file;
        }

		//Checking File Exists
		if(!file_exists($this->input_file)) {
			$this->log->writeLine('File Exists','No',true);
		} else {
			$this->log->writeLine('File Exists','Yes',true);
		}
		
		//Get File info
		$this->input_details = $this->get_file_info($this->input_file);
		//Logging File Details
		$this->log_file_info();

		//Get FFMPEG version
		$result = shell_output(FFMPEG_BINARY.' -version');
		$version = parse_version('ffmpeg',$result);

		$this->vconfigs['map_meta_data'] = 'map_meta_data';
		
		if(strstr($version,'Git')) {
			$this->vconfigs['map_meta_data'] = 'map_metadata';
		}
	}

	private function parseVideoInfo($output = '',$size=0)
	{
		# search the output for specific patterns and extract info
		# check final encoding message
		$info['size'] = $size;
		$audio_codec = false;

		if( $args = self::pregMatch( 'video:([0-9]+)kB audio:([0-9]+)kB global headers:[0-9]+kB muxing overhead', $output) ) {
			$video_size = (float)$args[1];
			$audio_size = (float)$args[2];
		}

		# check for last encoding update message
		if($args = self::pregMatch( '(frame=([^=]*) fps=[^=]* q=[^=]* L)?size=[^=]*kB time=([^=]*) bitrate=[^=]*kbits\/s[^=]*$', $output) ) {
			$frame_count = $args[2] ? (float)ltrim($args[2]) : 0;
		}

		$len = strlen($output);
		$findme = 'Duration';
		$findme1 = 'start';
		$pos = strpos($output, $findme);
		$pos = $pos + 10;
		$pos1 = strpos($output, $findme1);
		$bw = $len - ($pos1 - 5);
		$rest = substr($output, $pos, -$bw);

		$duration = explode(':',$rest);
		//Convert Duration to seconds
		$hours = $duration[0];
		$minutes = $duration[1];
		$seconds = $duration[2];
		
		$hours = $hours * 60 * 60;
		$minutes = $minutes * 60;

		$duration = $hours+$minutes+$seconds;

		$info['duration'] = $duration;
		if($duration)
		{
			$info['bitrate' ] = (integer)($info['size'] * 8 / 1024 / $duration);
			if( $frame_count > 0 ){
				$info['video_rate']	= (float)$frame_count / (float)$duration;
            }
			if( $video_size > 0 ){
				$info['video_bitrate']	= (integer)($video_size * 8 / $duration);
            }
			if( $audio_size > 0 ){
				$info['audio_bitrate']	= (integer)($audio_size * 8 / $duration);
            }
			if($args = self::pregMatch( "Input #0, ([^ ]+), from", $output) ) {
				$info['format'] = $args[1];
			}
		}

		# get video information
		if( $args = self::pregMatch( '([0-9]{2,4})x([0-9]{2,4})', $output ) ) {
			$info['video_width']    = $args[1];
			$info['video_height']   = $args[2];
			$info['video_wh_ratio'] = (float) $info['video_width'] / (float)$info['video_height'];
		}
		
		if($args = self::pregMatch('Video: ([^ ^,]+)',$output)) {
			$info['video_codec'] = $args[1];
		}

		# get audio information
		if($args = self::pregMatch( "Audio: ([^ ]+), ([0-9]+) Hz, ([^\n,]*)", $output) ) {
			$audio_codec = $info['audio_codec'] = $args[1];
			$audio_rate = $info['audio_rate'  ] = $args[2];
			$info['audio_channels'] = $args[3];
		}

		if((isset($audio_codec) && !$audio_codec) || !$audio_rate) {
			$args = self::pregMatch( "Audio: ([a-zA-Z0-9]+)(.*), ([0-9]+) Hz, ([^\n,]*)", $output);
			$info['audio_codec']    = $args[1];
			$info['audio_rate']     = $args[3];
			$info['audio_channels'] = $args[4];
		}

		return $info;
	}

	private static function pregMatch($in = false, $str = false)
	{
		if($in && $str) {
			preg_match("/$in/",$str,$args);
			return $args;
		}
		return false;
	}

	public function generateThumbs($array)
	{
		$input_file = $array['vid_file'];
		$duration = $array['duration'];
		$dim = $array['dim'];
		$num = $array['num'];

		if( $num > $duration ){
		    $num = $duration;
        }

		if (!empty($array['size_tag'])){
			$size_tag = $array['size_tag'];
		}

        $regenerateThumbs = false;
		if (!empty($array['file_directory'])){
			$regenerateThumbs = true;
			$file_directory = $array['file_directory'];
		}

		if (!empty($array['file_name'])){
			$filename = $array['file_name'];
		}
		$tmpDir = TEMP_DIR.DIRECTORY_SEPARATOR.getName($input_file);

		/*
			The format of $this->options["outputPath"] should be like this
			year/month/day/ 
			the trailing slash is important in creating directories for thumbs
		*/
		if(substr($this->options['outputPath'], strlen($this->options['outputPath']) - 1) !== '/'){
			$this->options['outputPath'] .= DIRECTORY_SEPARATOR;
		}
		
		mkdir($tmpDir,0777, true);

		$dimension = '';
		
		if(!empty($size_tag)) {
			$size_tag = $size_tag.'-';
		}

		if (!empty($file_directory) && !empty($filename)) {
			$thumbs_outputPath = $file_directory.DIRECTORY_SEPARATOR;
		} else {
			$thumbs_outputPath = $this->options['outputPath'];
		}

		if($dim!='original'){
			$dimension = ' -s '.$dim.' ';
		}


        $thumb_dir = THUMBS_DIR.DIRECTORY_SEPARATOR.$thumbs_outputPath;
        if(!is_dir($thumb_dir)){
            mkdir($thumb_dir,0755, true);
        }

		if($num > 1) {
			$division = $duration / $num;
			$num_length = strlen($num);

			for($count=0;$count<=$num;$count++)
			{
			    $thumb_file_number = str_pad((string)$count, $num_length, '0', STR_PAD_LEFT);
				if (empty($filename)){
					$file_name = getName($input_file).'-'.$size_tag.$thumb_file_number.'.jpg';
				} else {
					$file_name = $filename.'-'.$size_tag.$thumb_file_number.'.jpg';
				}
				
				$file_path = $thumb_dir.$file_name;

				$time_sec = (int)($division*$count);

				$command = $this->ffMpegPath." -ss $time_sec -i $input_file -pix_fmt yuvj422p -an -r 1 $dimension -y -f image2 -vframes 1 $file_path ";
				$output = $this->executeCommand($command);	

				//checking if file exists in temp dir
				if(file_exists($tmpDir.'/00000001.jpg')) {
					rename($tmpDir.'/00000001.jpg',THUMBS_DIR.DIRECTORY_SEPARATOR.$file_name);
				}

				if (!$regenerateThumbs && !file_exists($file_path))
				{
                    $TempLogData = "\r\n\r\n Command : $command ";
                    $TempLogData .= "\r\n\r\n OutPut : $output ";
                    $this->log->writeLine($TempLogData, true);
				}
			}
		} else {
			if (empty($filename)){
				$file_name = getName($input_file)."-{$size_tag}1.jpg";	
			} else {
				$file_name = $filename."-{$size_tag}1.jpg";	
			}
			
			$file_path = THUMBS_DIR.DIRECTORY_SEPARATOR.$thumbs_outputPath.$file_name;
			$command = $this->ffMpegPath." -i $input_file -an $dimension -y -f image2 -vframes $num $file_path ";
			$output = $this->executeCommand($command);
			if (!$regenerateThumbs && !file_exists($file_path)){
                $TempLogData = "\r\n Command : $command ";
                $TempLogData .= "\r\n File : $file_path ";
                $TempLogData .= "\r\n Output : $output ";
                $this->log->writeLine($TempLogData, true);
			}
		}
		rmdir($tmpDir);
	}

	public static function get_video_tracks($filepath)
	{
		$stats = stat($filepath);
		if($stats && is_array($stats))
		{
			$json = shell_exec(FFPROBE . ' -i "'.$filepath.'" -loglevel panic -print_format json -show_entries stream 2>&1');
			$tracks_json = json_decode($json, true)['streams'];
			$langs = array();
			foreach($tracks_json as $track)
			{
				if( $track['codec_type'] != 'audio' ){
					continue;
                }

				if( !isset($track['tags']) ){
					continue;
                }

				$map_id = $track['index'];
				$track = $track['tags'];

				if( !isset($track['language']) && !isset($track['LANGUAGE']) && !isset($track['title']) ){
					continue;
                }

				$title = '';
				if( isset($track['language']) ){
					$title .= $track['language'];
                } else if( isset($track['LANGUAGE']) ) {
					$title .= $track['LANGUAGE'];
                }

				if( isset($track['title']) ){
				    if( !empty($title) ){
				        $title .= ' : ';
                    }
					$title .= $track['title'];
                }

				$langs[$map_id] = $title;
			}
			return $langs;
		}
		return false;
	}

	public static function get_media_stream_id($type, $filepath)
	{
		$stats = stat($filepath);
		if($stats && is_array($stats))
		{
			$json = shell_exec(FFPROBE . ' -i "'.$filepath.'" -loglevel panic -print_format json -show_entries stream 2>&1');
			$tracks_json = json_decode($json, true)['streams'];
			$streams_ids = array();
			foreach($tracks_json as $track)
			{
				if( $track['codec_type'] != $type ){
					continue;
                }

				if( !isset($track['index']) ){
					continue;
                }

				if( $type == 'video' ){
				    return $track['index'];
                }
				$streams_ids[] = $track['index'];
			}
			return $streams_ids;
		}
		return false;
	}

	public static function get_video_basic_infos($filepath): array
    {
		$stats = stat($filepath);
		if($stats && is_array($stats))
		{
			$json = shell_exec(FFPROBE. ' -v quiet -print_format json -show_format -show_streams "'.$filepath.'"');
			$data = json_decode($json,true);

			$video = NULL;
			foreach($data['streams'] as $stream)
			{
				if( $stream['codec_type'] == 'video' ) {
					$video = $stream;
					break;
				}
			}

			if($video) {
				$info = array();
				$info['duration'] = SetTime($data['format']['duration']);
				$info['width']    = (int) $video['width'];
				$info['height']   = (int) $video['height'];
				return $info;
			}
			return array();
		}
		return array();
	}

}