<?php

class FFMpeg
{
    public /*string*/ $conversion_type = '';
    public /*string*/ $file_directory = '';
    public /*string*/ $file_name = '';
    public /*string*/ $lock_file = '';
    public /*string*/ $input_file = '';
    public /*int*/ $audio_track = -1;
    public /*array*/ $input_details = [];
	public /*SLog*/ $log;
	public /*string*/ $output_dir = '';
	public /*string*/ $output_file = '';
    public /*array*/ $video_files = [];

	public function __construct(SLog $log)
	{
        $this->log = $log;
	}

    /**
     * Function used to get file information using FFPROBE
     *
     * @param null|string $file_path
     *
     */
	function get_file_info($file_path=NULL): array
    {
		if(!$file_path){
			$file_path = $this->input_file;
        }

		$info['video_wh_ratio']      = 'N/A';
		$info['video_color']         = 'N/A';
		$info['path']                = $file_path;

		$cmd = config('ffprobe_path'). ' -v quiet -print_format json -show_format -show_streams \''.$file_path.'\'';
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

		if(!$info['duration']) {
			$CMD = config('media_info').' \'--Inform=General;%Duration%\' \''. $file_path.'\' 2>&1';
			$info['duration'] = round((int)shell_output( $CMD )/1000,2);
		}

		$video_rate = explode('/',$info['video_rate']);
		$int_1_video_rate = (int)$video_rate[0];
		$int_2_video_rate = (int)$video_rate[1];

		$CMD = config('media_info').' \'--Inform=Video;\' '.$file_path;

		$results = shell_output($CMD);
		$needle_start = 'Original height';
		$needle_end = 'pixels';
		$original_height = find_string($needle_start,$needle_end,$results);
		$original_height[1] = str_replace(' ', '', $original_height[1]);
		if( !empty($original_height) ) {
			$o_height = trim($original_height[1]);
			$o_height = (int)$o_height;
			if($o_height!=0&&!empty($o_height)) {
				$info['video_height'] = $o_height;
			}
		}
		$needle_start = 'Original width';
		$original_width = find_string($needle_start,$needle_end,$results);
		$original_width[1] = str_replace(' ', '', $original_width[1]);
		if( !empty($original_width) ) {
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

	function log($name,$value)
	{
		$this->log .= $name.' : '.$value.PHP_EOL;
	}
	
	/**
	 * Function used to start log
	 */
	function start_log()
	{
		$TemplogData = 'Started on '.NOW().' - '.date('Y M d').PHP_EOL.PHP_EOL;
		$TemplogData .= 'Checking File...'.PHP_EOL;
		$TemplogData .= 'File : '.$this->input_file;
		$this->log->writeLine('Starting Conversion', $TemplogData, true);
	}
	
	/**
	 * Function used to log video info
	 */
	function log_file_info()
	{
		$details = $this->input_details;
		$configLog = '';
        foreach($details as $name => $value) {
            $configLog .= '<strong>'.$name.'</strong> : '.$value.PHP_EOL;
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
				$configLog .= '<strong>'.$name.'</strong> : '.$value.PHP_EOL;
			}
		} else {
			$configLog = 'Unknown file details - Unable to get video details using FFMPEG'.PHP_EOL;
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

    function unLock()
    {
        if( file_exists($this->lock_file) ){
            unlink($this->lock_file);
        }
    }

	function ClipBucket()
	{
		//We will now add a loop that will check weather
		while( true )
		{
            if( $this->isLocked(config('max_conversion')) ){
                // Prevent video_convert action to use 100% cpu while waiting for queued videos to end conversion
                sleep(5);
                continue;
            }

            $this->start_time_check();
            $this->start_log();
            $this->prepare();

            $max_duration = config('max_video_duration') * 60;
            if( $this->input_details['duration'] > $max_duration ) {
                $max_duration_seconds = $max_duration / 60;
                $log = 'Video duration was '.$this->input_details['duration'].' minutes and Max video duration is '.$max_duration_seconds.' minutes, Therefore Video cancelled'.PHP_EOL;
                $log .= 'Conversion_status : failed'.PHP_EOL;
                $log .= 'Failed Reason : Max Duration Configurations'.PHP_EOL;
                $this->log->writeLine('Max Duration configs', $log, true);
                break;
            }

            $log = '';
            if( file_exists($this->input_file) ){

                try {
                    $this->generateAllThumbs();
                } catch(Exception $e) {
                    $log .= PHP_EOL.'Error Occured : '.$e->getMessage().PHP_EOL;
                }

                $log .= PHP_EOL.'====== End : Thumbs Generation ======='.PHP_EOL;
            } else {
                $log .= 'Input file is missing ; no thumbs generation !'.PHP_EOL;
            }

            $this->log->writeLine('Thumbs Generation', $log, true);

            if( config('extract_subtitles') ){
                $this->extract_subtitles();
            }

            $resolutions = $this->get_eligible_resolutions();

            $log = '';

            if( !empty($resolutions) ){
                switch( $this->conversion_type ){
                    default:
                        $this->conversion_type = 'mp4';
                    case 'mp4':
                        $ext = getExt($this->input_file);
                        if( config('stay_mp4') == 'yes' && $ext == 'mp4'){
                            $resolution = $this->get_max_resolution_from_file();
                            $this->video_files[] = $resolution;

                            $this->output_file = $this->output_dir.$this->file_name.'-'.$resolution.'.'.$this->conversion_type;
                            copy($this->input_file,$this->output_file);
                            break;
                        }

                        foreach($resolutions as $res){
                            $this->convert_mp4($res);
                        }
                        break;

                    case 'hls':
                        $this->convert_hls($resolutions);
                        break;
                }
            } else {
                $log = '<b>No video resolution available for conversion</b>'.PHP_EOL;
                $log .= '<i>(Video resolution is lower than the lowest resolution enabled)</i>'.PHP_EOL;
            }

            $this->end_time_check();
            $this->total_time();

            $log .= 'Time Took : '.$this->total_time.' seconds'.PHP_EOL;

            if(file_exists($this->output_file) && filesize($this->output_file) > 0) {
                $log .= 'Conversion_status : completed';
            } else {
                $log .= 'Conversion_status : failed';
            }

            $this->log->writeLine('Conversion Completed', $log, true);
            break;
		}
        $this->unLock();
	}

    private function extract_subtitles()
    {
        global $cbvideo, $db;

        $log = '';
        $subtitles = FFMpeg::get_track_infos($this->input_file, 'subtitle');

        if( count($subtitles) > 0 ){
            $video = $cbvideo->get_video($this->file_name,true);
            $subtitle_dir = SUBTITLES_DIR.DIRECTORY_SEPARATOR.$this->file_directory;
            if(!is_dir($subtitle_dir)){
                mkdir($subtitle_dir,0755, true);
            }

            $count = 0;
            foreach( $subtitles as $map_id => $data ) {
                if( isset($data['codec_name']) && in_array($data['codec_name'], ['hdmv_pgs_subtitle','dvd_subtitle']) ){
                    $log .= PHP_EOL.' Subtitle '.$data['title'].' can\'t be extracted because it\'s in bitmap format';
                    continue;
                }

                $count++;
                $display_count = str_pad((string)$count, 2, '0', STR_PAD_LEFT);
                $command = config('ffmpegpath').' -i '.$this->input_file.' -map 0:'.$map_id.' -f '.config('subtitle_format').' '.$subtitle_dir.$this->file_name.'-'.$display_count.'.srt 2>&1';
                $log .= PHP_EOL.$command;
                $output = shell_exec($command);
                $db->insert(tbl('video_subtitle'),['videoid','number','title'],[$video['videoid'], $display_count, $data['title']]);
                if( DEVELOPMENT_MODE ) {
                    $log .= PHP_EOL.$output;
                }
            }

            $log .= PHP_EOL.'====== End : Subtitles extraction ======='.PHP_EOL;
            $this->log->writeLine('Subtitles extraction', $log, true);
        }
    }

    private function get_eligible_resolutions(): array
    {
        global $myquery;
        $resolutions = $myquery->getEnabledVideoResolutions();
        $eligible_resolutions = [];

        foreach( $resolutions as $key => $value ) {
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

            $res = [];

            // Here we must check width and height to be able to import other formats than 16/9 (For example : 1920x800, 1800x1080, ...)
            if( $this->input_details['video_width'] >= $video_width_test || $this->input_details['video_height'] >= $video_height_test ) {
                $res['video_width']  = $video_width;
                $res['video_height'] = $video_height;
                $res['height']		 = $video_height;

                $eligible_resolutions[] = $res;
            }
        }

        return $eligible_resolutions;
    }

    private function get_video_rate_param($video_rate): float
    {
        $conf_vrate = config('vrate');

        if( $video_rate <= $conf_vrate ){
            $final_vrate = $video_rate;
        } else {
            $div = intdiv(max($video_rate,$conf_vrate),min($video_rate,$conf_vrate));
            if( $div == 1 ){
                $final_vrate = max($video_rate,$conf_vrate)/ceil($video_rate/$conf_vrate);
            } else {
                $final_vrate = $video_rate/$div;
            }
        }
        return $final_vrate;
    }

    private function get_conversion_option($type, array $resolution = []): string
    {
        $cmd = '';
        switch($type)
        {
            case 'global':
                $cmd .= ' -y';
                $cmd .= ' -hide_banner';
                break;

            case 'video_global':
                // Video Codec
                $cmd .= ' -vcodec '.config('video_codec');
                if( config('video_codec') == 'libx264' ) {
                    $cmd .= ' -preset medium';
                }
                // Video Rate
                $original_video_framerate = $this->input_details['video_rate'];
                $framerate = self::get_video_rate_param($this->input_details['video_rate']);
                $cmd .= ' -r '.$framerate;
                $this->log->writeLine('Video framerate calculation', 'Original rate : '.$original_video_framerate.', final rate : '.$framerate.PHP_EOL, true);
                // Fix for browsers compatibility : yuv420p10le seems to be working only on Chrome like browsers
                if( config('force_8bits') ){
                    $cmd .= ' -pix_fmt yuv420p';
                }
                // Fix rare video conversion fail
                $cmd .= ' -max_muxing_queue_size 1024';
                $cmd .= ' -start_at_zero';
                // Ratio
                if ($this->input_details['video_wh_ratio'] >= 2.3){
                    $ratio = '21/9';
                } else if ($this->input_details['video_wh_ratio'] >= 1.6){
                    $ratio = '16/9';
                } else {
                    $ratio = '4/3';
                }
                $cmd .= ' -aspect '.$ratio;
                break;

            case 'video_mp4':
                global $myquery;
                // Video Bitrate
                $cmd .= ' -vb '.$myquery->getVideoResolutionBitrateFromHeight($resolution['height']);
                // Resolution
                $cmd .= ' -s '.$resolution['video_width'].'x'.$resolution['video_height'];
                break;

            case 'video_hls':
                global $myquery;
                $count = 0;
                $bitrates = '';
                $resolutions = '';
                foreach($resolution as $res){
                    $video_bitrate = $myquery->getVideoResolutionBitrateFromHeight($res['height']);
                    $this->video_files[] = $res['height'];
                    $bitrates .= ' -b:v:'.$count.' '.$video_bitrate;
                    $resolutions .= ' -s:v:'.$count.' '.$res['video_width'].'x'.$res['video_height'];
                    $count++;
                }
                $cmd .= $bitrates.$resolutions;
                break;

            case 'audio_global':
                // Audio Bitrate
                $cmd .= ' -b:a '.config('sbrate');
                // Audio Rate
                $cmd .= ' -ar '.config('srate');
                // Audio Codec
                $cmd .= ' -c:a '.config('audio_codec');
                if( config('audio_codec') == 'aac' ){
                    $cmd .= ' -profile:a aac_low';
                }
                // Fix for ChromeCast : Forcing stereo mode
                if( config('chromecast_fix') ){
                    $cmd .= ' -ac 2';
                }
                break;

            case 'mp4':
                $cmd .= ' -f '.$this->conversion_type;
                $cmd .= ' -movflags faststart';
                break;

            case 'map_mp4':
                // Keeping video map
                $video_track_id = self::get_media_stream_id('video', $this->input_file);
                $cmd .= ' -map 0:'.$video_track_id;
                // Making selected audio track the primary one
                if( $this->audio_track >= 0 ){
                    $cmd .= ' -map 0:'.$this->audio_track;
                }
                // Keeping audio tracks
                if( config('keep_audio_tracks') || $this->conversion_type == 'hls' ){
                    $audio_tracks = self::get_media_stream_id('audio', $this->input_file);
                    foreach($audio_tracks as $track_id){
                        if( $track_id != $this->audio_track ){
                            $cmd .= ' -map 0:'.$track_id;
                        }
                    }
                }
                // Keeping subtitles
                if( config('keep_subtitles') || $this->conversion_type == 'hls' ) {
                    $subtitles = self::get_track_infos($this->input_file, 'subtitle');
                    foreach( $subtitles as $track_id => $data ) {
                        if( in_array($data['codec_name'], ['hdmv_pgs_subtitle','dvd_subtitle']) ){
                            continue;
                        }

                        $cmd .= ' -map 0:' . $track_id;
                    }

                    if( $this->conversion_type == 'mp4' ){
                        $cmd .= ' -c:s mov_text';
                    } else {
                        $cmd .= ' -c:s '.config('subtitle_format');
                    }
                }
                break;

            case 'map_hls':
                global $myquery;

                $map = '';
                $var_stream_map = ' -var_stream_map \'';
                $video_track_id = self::get_media_stream_id('video', $this->input_file);
                $count = 0;
                foreach($resolution as $res){
                    $map .= ' -map 0:'.$video_track_id;
                    $var_stream_map .= ' v:'.$count.',name:video_'.$myquery->getVideoResolutionTitleFromHeight($res['height']).',agroup:audios';

                    $count++;
                }

                $count = 0;
                $audio_tracks = self::get_media_stream_id('audio', $this->input_file);
                foreach($audio_tracks as $audio_track_id){
                    $map .= ' -map 0:'.$audio_track_id;
                    $var_stream_map .= ' a:'.$count.',name:audio_'.($count+1).',agroup:audios';
                    if( $audio_track_id == $this->audio_track ){
                        $var_stream_map .= ',default:yes';
                    }

                    $count++;
                }

                $var_stream_map .= '\'';

                $cmd .= $map.$var_stream_map;

                break;

            case 'hls':
                $cmd .= ' -hls_time 4';
                $cmd .= ' -force_key_frames "expr:gte(t,n_forced*1)"';
                $cmd .= ' -hls_playlist_type vod';
                $cmd .= ' -master_pl_name "index.m3u8"';
                $cmd .= ' '.$this->output_dir.'%v.m3u8';
                $this->output_file = $this->output_dir.'index.m3u8';
                break;
        }
        return $cmd.' ';
    }

    private function convert_hls(array $resolutions)
    {
        $cmd = config('ffmpegpath');
        $cmd .= $this->get_conversion_option('global');
        $cmd .= ' -i '.$this->input_file;
        $cmd .= $this->get_conversion_option('video_global');
        $cmd .= $this->get_conversion_option('audio_global');
        $cmd .= $this->get_conversion_option('video_hls', $resolutions);
        $cmd .= $this->get_conversion_option('map_hls', $resolutions);
        $cmd .= $this->get_conversion_option('hls');
        $cmd .= ' 2>&1';

        $log = PHP_EOL.PHP_EOL.'== Conversion Command =='.PHP_EOL.PHP_EOL;
        $log .= $cmd;

        $output = shell_exec($cmd);
        if( DEVELOPMENT_MODE ) {
            $log .= PHP_EOL.PHP_EOL.'== Conversion Output =='.PHP_EOL.PHP_EOL;
            $log .= $output;
        }

        $this->log->writeLine('Conversion Ouput', $log, true);
    }

	/**
	 * Function used to convert video
	 *
	 * @param array $more_res
	 */
	function convert_mp4(array $more_res)
	{
        $opt_av = $this->get_conversion_option('global');
        $opt_av .= $this->get_conversion_option('video_global');
        $opt_av .= $this->get_conversion_option('video_mp4', $more_res);
        $opt_av .= $this->get_conversion_option('audio_global');
        $opt_av .= $this->get_conversion_option('map_mp4');
        $opt_av .= $this->get_conversion_option('mp4');

        $this->output_file = $this->output_dir.$this->file_name.'-'.$more_res['height'].'.'.$this->conversion_type;

		$tmp_file = time().RandomString(5).'.tmp';

        $TemplogData = 'Converting Video file '.$more_res['height'].' @ '.date('Y-m-d H:i:s').PHP_EOL;
        $command = config('ffmpegpath').' -i '.$this->input_file.$opt_av.' '.$this->output_file.' 2> '.TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file;

        $output = shell_exec($command);

        if(file_exists(TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file)){
            $output = $output ? $output : join('', file(TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file));
            unlink(TEMP_DIR.DIRECTORY_SEPARATOR.$tmp_file);
        }

        if(file_exists($this->output_file) && filesize($this->output_file)>0)
        {
            $this->video_files[] = $more_res['height'];
            $TemplogData .= PHP_EOL.'Files resolution : '.$more_res['height'].PHP_EOL;
        } else {
            $TemplogData .= PHP_EOL.PHP_EOL.'File doesn\'t exist. Path: '.$this->output_file.PHP_EOL.PHP_EOL;
        }

        $TemplogData .= PHP_EOL.PHP_EOL.'== Conversion Command =='.PHP_EOL.PHP_EOL;
        $TemplogData .= $command;

        if( DEVELOPMENT_MODE ) {
            $TemplogData .= PHP_EOL.PHP_EOL.'== Conversion OutPut =='.PHP_EOL.PHP_EOL;
            $TemplogData .= $output;
        }

		$TemplogData .= PHP_EOL.'End resolutions @ '.date('Y-m-d H:i:s').PHP_EOL.PHP_EOL;
		$this->log->writeLine('Conversion Ouput', $TemplogData, true);

		$this->output_details = $this->get_file_info($this->output_file);
		$this->log_ouput_file_info();
	}

	function prepare()
	{
		//Checking File Exists
		if(!file_exists($this->input_file)) {
			$this->log->writeLine('File Exists','No',true);
		}
		
		//Get File info
		$this->input_details = $this->get_file_info($this->input_file);
		//Logging File Details
		$this->log_file_info();

        switch($this->conversion_type)
        {
            default:
            case 'mp4':
                $this->output_dir = VIDEOS_DIR.DIRECTORY_SEPARATOR.$this->file_directory;
                break;
            case 'hls':
                $this->output_dir = VIDEOS_DIR.DIRECTORY_SEPARATOR.$this->file_directory.$this->file_name.DIRECTORY_SEPARATOR;
                break;
        }

        if(!is_dir($this->output_dir)){
            mkdir($this->output_dir,0755, true);
        }
	}

    public function generateAllThumbs()
    {
        $thumbs_res_settings = thumbs_res_settings_28();

        $thumbs_settings = [];
        $thumbs_settings['vid_file'] = $this->input_file;
        $thumbs_settings['duration'] = $this->input_details['duration'];
        $thumbs_settings['num']      = config('num_thumbs');

        foreach( $thumbs_res_settings as $key => $thumbs_size ) {
            $height_setting = $thumbs_size[1];
            $width_setting = $thumbs_size[0];

            if( $key == 'original' ) {
                $thumbs_settings['dim'] = $key;
                $thumbs_settings['size_tag'] = $key;
            } else {
                $thumbs_settings['dim'] = $width_setting.'x'.$height_setting;
                $thumbs_settings['size_tag'] = $width_setting.'x'.$height_setting;
            }

            $this->generateThumbs($thumbs_settings);
        }
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
		
		mkdir($tmpDir,0777, true);

		$dimension = '';
		
		if(!empty($size_tag)) {
			$size_tag = $size_tag.'-';
		}

		if (!empty($file_directory) && !empty($filename)) {
			$thumbs_outputPath = $file_directory.DIRECTORY_SEPARATOR;
		} else {
			$thumbs_outputPath = $this->file_directory;
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

				$command = config('ffmpegpath').' -ss '.$time_sec.' -i '.$input_file.' -pix_fmt yuvj422p -an -r 1 '.$dimension.' -y -f image2 -vframes 1 '.$file_path.' 2>&1';
				$output = shell_exec($command);

				//checking if file exists in temp dir
				if(file_exists($tmpDir.'/00000001.jpg')) {
					rename($tmpDir.'/00000001.jpg',THUMBS_DIR.DIRECTORY_SEPARATOR.$file_name);
				}

				if (!$regenerateThumbs && !file_exists($file_path))
				{
                    $TempLogData = PHP_EOL.PHP_EOL.'Command : '.$command;
                    $TempLogData .= PHP_EOL.PHP_EOL.'OutPut : '.$output;
                    $this->log->writeLine($TempLogData, true);
				}
			}
		} else {
			if (empty($filename)){
				$file_name = getName($input_file).'-'.$size_tag.'1.jpg';
			} else {
				$file_name = $filename.'-'.$size_tag.'1.jpg';
			}
			
			$file_path = THUMBS_DIR.DIRECTORY_SEPARATOR.$thumbs_outputPath.$file_name;
			$command = config('ffmpegpath').' -i '.$input_file.' -an '.$dimension.' -y -f image2 -vframes '.$num.' '.$file_path.' 2>&1';
			$output = shell_exec($command);
			if (!$regenerateThumbs && !file_exists($file_path)){
                $TempLogData = PHP_EOL.'Command : '.$command ;
                $TempLogData .= PHP_EOL.'File : '.$file_path ;
                $TempLogData .= PHP_EOL.'Output : '.$output ;
                $this->log->writeLine($TempLogData, true);
			}
		}
		rmdir($tmpDir);
	}

    public static function get_track_infos(string $filepath, string $type): array
    {
        $stats = stat($filepath);
        if($stats && is_array($stats)) {
            $json = shell_exec(config('ffprobe_path') . ' -i "'.$filepath.'" -loglevel panic -print_format json -show_entries stream 2>&1');
            $tracks_json = json_decode($json, true)['streams'];
            $data = [];
            foreach($tracks_json as $track) {
                if( $track['codec_type'] != $type ){
                    continue;
                }

                if( !isset($track['tags']) ){
                    continue;
                }

                $map_id = $track['index'];
                $tags = $track['tags'];

                if( !isset($tags['language']) && !isset($tags['LANGUAGE']) && !isset($tags['title']) ){
                    continue;
                }

                $title = '';
                if( isset($tags['language']) ){
                    $title .= $tags['language'];
                } else if( isset($tags['LANGUAGE']) ) {
                    $title .= $tags['LANGUAGE'];
                }

                if( isset($tags['title']) ){
                    if( !empty($title) ){
                        $title .= ' : ';
                    }
                    $title .= $tags['title'];
                }

                $data[$map_id]['title'] = $title;
                if( isset($track['codec_name']) ){
                    $data[$map_id]['codec_name'] = $track['codec_name'];
                }

            }
            return $data;
        }
        return [];
    }

	public static function get_track_title(string $filepath, string $type)
	{
		$stats = stat($filepath);
		if($stats && is_array($stats))
		{
			$json = shell_exec(config('ffprobe_path') . ' -i "'.$filepath.'" -loglevel panic -print_format json -show_entries stream 2>&1');
			$tracks_json = json_decode($json, true)['streams'];
			$langs = [];
			foreach($tracks_json as $track)
			{
				if( $track['codec_type'] != $type ){
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
		if( file_exists($filepath) )
		{
			$json = shell_exec(config('ffprobe_path') . ' -i "'.$filepath.'" -loglevel panic -print_format json -show_entries stream 2>&1');
			$tracks_json = json_decode($json, true)['streams'];
			$streams_ids = [];
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
			$json = shell_exec(config('ffprobe_path'). ' -v quiet -print_format json -show_format -show_streams "'.$filepath.'"');
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
				$info = [];
				$info['duration'] = SetTime($data['format']['duration']);
				$info['width']    = (int) $video['width'];
				$info['height']   = (int) $video['height'];
				return $info;
			}
			return [];
		}
		return [];
	}

    private function get_max_resolution_from_file()
    {
        global $myquery;
        $video_resolutions = $myquery->getVideoResolutions();
        $max_resolution = false;

        foreach($video_resolutions as $ratio) {
            foreach( $ratio as $res ) {
                $video_height = (int)$res['height'];
                $video_width = (int)$res['witdh'];

                // This option allow video with a 1% lower resolution to be included in the superior resolution
                // For example : 1900x800 will be allowed in 1080p resolution
                if ( config( 'allow_conversion_1_percent' ) == 'yes' ) {
                    $video_height_test = floor( $video_height * 0.99 );
                    $video_width_test = floor( $video_width * 0.99 );
                } else {
                    $video_height_test = $video_height;
                    $video_width_test = $video_width;
                }

                // Here we must check width and height to be able to import other formats than 16/9 (For example : 1920x800, 1800x1080, ...)
                if ( $this->input_details['video_width'] >= $video_width_test || $this->input_details['video_height'] >= $video_height_test ) {
                    if ( $video_height > $max_resolution ) {
                        $max_resolution = $video_height;
                    }
                }
            }
        }

        return $max_resolution;
    }
}