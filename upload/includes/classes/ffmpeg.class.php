<?php
class FFMpeg
{
    public $conversion_type = '';
    public $file_directory = '';
    public $file_name = '';
    public $lock_file = '';
    public $input_file = '';
    public $audio_track = -1;
    public $input_details = [];
    public $output_details = [];
    public $log;
    public $output_dir = '';
    public $output_file = '';
    public $video_files = [];

    private $start_time;
    private $end_time;
    private $total_time;
    private $total_pixels = 0;
    private $convert_percent_done = 0;

    private $frame_rate;

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
    function get_file_info($file_path = null): array
    {
        if (!$file_path) {
            $file_path = $this->input_file;
        }

        $info['video_wh_ratio'] = 'N/A';
        $info['video_color'] = 'N/A';
        $info['path'] = $file_path;

        $cmd = config('ffprobe_path') . ' -i "' . $file_path . '" -v quiet -print_format json -show_format -show_streams';
        $output = System::shell_output($cmd);
        $output = preg_replace('/([a-zA-Z 0-9\r\n]+){/', '{', $output, 1);

        $data = json_decode($output, true);

        $video = null;
        $audio = null;
        foreach ($data['streams'] as $stream) {
            if ($stream['codec_type'] == 'video' && empty($video)) {
                $video = $stream;
                continue;
            }

            if ($stream['codec_type'] == 'audio' && empty($audio)) {
                $audio = $stream;
                continue;
            }

            if (!empty($video) && !empty($audio)) {
                break;
            }
        }

        $info['fov'] = self::getFovFromStream($data['streams']);

        $info['format'] = $data['format']['format_name'];
        $info['duration'] = round($data['format']['duration'], 2);
        $info['video_bitrate'] = (int)max(($video['bit_rate'] ?? 0), ($data['format']['bit_rate'] ?? 0));
        $info['video_width'] = (int)$video['width'];
        $info['video_height'] = (int)$video['height'];
        $info['bits_per_raw_sample'] = (int)$video['bits_per_raw_sample'];

        if ($video['height']) {
            $info['video_wh_ratio'] = (int)$video['width'] / (int)$video['height'];
        }
        $info['video_codec'] = $video['codec_name'];
        $info['video_rate'] = $video['r_frame_rate'];
        $info['size'] = filesize($file_path);
        $info['audio_codec'] = $audio['codec_name'];
        $info['audio_bitrate'] = (int)$audio['bit_rate'];
        $info['audio_rate'] = (int)$audio['sample_rate'];
        $info['audio_channels'] = (float)$audio['channels'];
        $info['rotation'] = (float)$video['tags']['rotate'];

        if (!$info['duration']) {
            $CMD = config('media_info') . ' \'--Inform=General;%Duration%\' \'' . $file_path . '\' 2>&1';
            $info['duration'] = round((int)System::shell_output($CMD) / 1000, 2);
        }

        $video_rate = explode('/', $info['video_rate']);
        $int_1_video_rate = (int)$video_rate[0];
        $int_2_video_rate = (int)$video_rate[1];

        $CMD = config('media_info') . ' \'--Inform=Video;\' ' . $file_path;

        $results = System::shell_output($CMD);
        $needle_start = 'Original height';
        $needle_end = 'pixels';
        $original_height = find_string($needle_start, $needle_end, $results);
        $original_height[1] = str_replace(' ', '', $original_height[1]);
        if (!empty($original_height)) {
            $o_height = trim($original_height[1]);
            $o_height = (int)$o_height;
            if ($o_height != 0 && !empty($o_height)) {
                $info['video_height'] = $o_height;
            }
        }
        $needle_start = 'Original width';
        $original_width = find_string($needle_start, $needle_end, $results);
        $original_width[1] = str_replace(' ', '', $original_width[1]);
        if (!empty($original_width)) {
            $o_width = trim($original_width[1]);
            $o_width = (int)$o_width;
            if ($o_width != 0 && !empty($o_width)) {
                $info['video_width'] = $o_width;
            }
        }

        if ($int_2_video_rate != 0) {
            $info['video_rate'] = $int_1_video_rate / $int_2_video_rate;
        }
        return $info;
    }

    private static function getFovFromStream($streams) {
        foreach ($streams as $stream) {
            if (isset($stream['side_data_list'])) {
                foreach ($stream['side_data_list'] as $sideData) {
                    if (isset($sideData['projection'])) {
                        switch ($sideData['projection']) {
                            case 'equirectangular':
                                return 360;

                            case 'hemispherical_equirectangular':
                            case 'fisheye':
                                return 180;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * Function used to log video info
     */
    function log_input_file_infos()
    {
        $details = $this->input_details;
        $this->log->newSection('Input file details');
        foreach ($details as $name => $value) {
            $this->log->writeLine('- <b>' . $name . '</b> : ' . $value);
        }
    }

    /**
     * Function log outpuit file details
     */
    function log_ouput_file_info()
    {
        $details = $this->output_details;

        $infos = '';
        foreach ($details as $name => $value) {
            $infos .='- <b>' . $name . '</b> : ' . $value.'<br/>';
        }

        $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output file details : </p><p class="content">'.$infos.'</p></div>', false, true);
    }

    function time_check()
    {
        $time = microtime();
        $time = explode(' ', $time);
        return $time[1] + $time[0];
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
        $this->total_time = round(($this->end_time - $this->start_time), 4);
    }

    function isLocked(): bool
    {
        $max_conversion = config('max_conversion');
        for ($i = 0; $i < $max_conversion; $i++) {
            $conv_file = DirPath::get('temp') . 'conv_lock' . $i . '.loc';
            if (!file_exists($conv_file)) {
                $this->lock_file = $conv_file;
                $file = fopen($conv_file, 'w+');
                fwrite($file, 'converting..');
                fclose($file);
                return false;
            }
        }
        return true;
    }

    function unLock()
    {
        if (file_exists($this->lock_file)) {
            unlink($this->lock_file);
        }
    }

    /**
     * @throws Exception
     */
    function ClipBucket()
    {
        $this->log->newSection('Conversion lock');
        while($this->isLocked()){
            // Prevent video_convert action to use 100% cpu while waiting for queued videos to end conversion
            $this->log->writeLine(date('Y-m-d H:i:s').' - Waiting for conversion lock...');
            sleep(5);
        }

        $this->log->writeLine(date('Y-m-d H:i:s').' - Starting conversion...');
        update_video_by_filename($this->file_name, ['status'], ['Processing']);

        $this->start_time_check();
        $this->prepare();

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '329') && !empty($this->input_details['video_width']) && !empty($this->input_details['video_height'])) {
            $aspect_ratio = (int)$this->input_details['video_width'] / (int)$this->input_details['video_height'];
            update_video_by_filename($this->file_name, ['aspect_ratio'], [$aspect_ratio]);
        }

        $max_duration = config('max_video_duration') * 60;
        if ($this->input_details['duration'] > $max_duration) {
            $max_duration_seconds = $max_duration / 60;
            $this->log->newSection('Conversion failed');
            $this->log->writeLine('Video duration was ' . $this->input_details['duration'] . ' minutes and Max video duration is ' . $max_duration_seconds . ' minutes');
            $this->log->writeLine('Conversion_status : failed');
            $this->unLock();
            return;
        }

        if (file_exists($this->input_file)) {
            try {
                $this->generateAllThumbs();
            } catch (\Exception $e) {
                $this->log->writeLine(date('Y-m-d H:i:s').' - Error occured : ' . $e->getMessage());
            }

        } else {
            $this->log->writeLine('Input file is missing ; no thumbs generation !');
        }

        if (config('extract_subtitles')) {
            $this->extract_subtitles();
        }

        $resolutions = $this->get_eligible_resolutions();
        if (config('only_keep_max_resolution')=='yes') {
            $max_resolution = -1;
            $max_key = -1;
            foreach ($resolutions as $key => $resolution) {
                if ($resolution['height'] > $max_resolution) {
                    $max_resolution = $resolution['height'];
                    $max_key = $key;
                }
            }
            $resolutions = [ $resolutions[$max_key] ];
        }

        $this->log->newSection('FFMpeg '.strtoupper($this->conversion_type).' conversion');
        if (!empty($resolutions)) {
            switch ($this->conversion_type) {
                default:
                    $this->conversion_type = 'mp4';
                case 'mp4':
                    $ext = getExt($this->input_file);
                    if (config('stay_mp4') == 'yes' && $ext == 'mp4') {
                        $this->log->writeLine('<b>Stay MP4 as it is enabled, no conversion done</b>');
                        $resolution = $this->get_max_resolution_from_file();
                        $this->video_files[] = $resolution;
                        $this->output_file = $this->output_dir . $this->file_name . '-' . $resolution . '.' . $this->conversion_type;
                        copy($this->input_file, $this->output_file);
                        break;
                    }

                    $this->set_total_pixels($resolutions);
                    foreach ($resolutions as $res) {
                        $this->convert_mp4($res);
                    }
                    break;

                case 'hls':
                    $this->convert_hls($resolutions);
                    break;
            }
        } else {
            $this->log->writeLine('<b>Video resolution is lower than lower resolution enabled : no video resolution available for conversion</b>');
        }

        $this->end_time_check();
        $this->total_time();

        $this->log->newSection('Conversion completed');
        $this->log->writeLine(date('Y-m-d H:i:s').'- Time Took : ' . $this->total_time . ' seconds');

        if( !empty($this->video_files) && file_exists($this->output_file) && filesize($this->output_file) > 0 ){
            $conversion_status = 'completed';
            $video_status = 'Successful';
        } else {
            $conversion_status = 'failed';
            $video_status = 'Failed';
        }

        $this->log->writeLine('Conversion_status : '.$conversion_status);
        setVideoStatus($this->file_name, $video_status, false, true);

        $this->unLock();
    }

    private function set_total_pixels($resolutions){
        $total = 0;
        foreach ($resolutions as $res) {
            $total += $res['video_height'] * $res['video_width'];
        }
        $this->total_pixels = $total;
    }

    /**
     * @throws Exception
     */
    public function extract_subtitles()
    {
        $this->log->newSection('Subtitle extraction');

        $subtitles = FFMpeg::get_track_infos($this->input_file, 'subtitle');

        if (count($subtitles) > 0) {
            $video = CBvideo::getInstance()->get_video($this->file_name, true);
            $subtitle_dir = DirPath::get('subtitles') . $this->file_directory;
            if (!is_dir($subtitle_dir)) {
                mkdir($subtitle_dir, 0755, true);
            }

            $count = 0;
            foreach ($subtitles as $map_id => $data) {
                $this->log->writeLine(date('Y-m-d H:i:s').' - Extracting '.$data['title'].'...');

                if( empty($data['codec_name']) ){
                    $this->log->writeLine(date('Y-m-d H:i:s').' => Subtitle ' . $data['title'] . ' can\'t be extracted because format is not specified');
                    continue;
                }

                if( in_array($data['codec_name'], ['hdmv_pgs_subtitle', 'dvd_subtitle']) ){
                    $this->log->writeLine(date('Y-m-d H:i:s').' => Subtitle ' . $data['title'] . ' can\'t be extracted because it\'s in bitmap format');
                    continue;
                }

                $count++;
                $display_count = str_pad((string)$count, 2, '0', STR_PAD_LEFT);
                $command = config('ffmpegpath') . ' -i ' . $this->input_file . ' -map 0:' . $map_id . ' -f ' . config('subtitle_format') . ' ' . $subtitle_dir . $this->file_name . '-' . $display_count . '.srt 2>&1';
                if (in_dev()) {
                    $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Command : </p><p class="content">'.$command.'</p></div>', false, true);
                }

                $output = shell_exec($command);
                if (in_dev()) {
                    $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output : </p><p class="content">'.$output.'</p></div>', false, true);
                }
                Clipbucket_db::getInstance()->insert(tbl('video_subtitle'), ['videoid', 'number', 'title'], [$video['videoid'], $display_count, $data['title']]);
            }
        } else {
            $this->log->writeLine('No subtitle to extract');
        }
    }

    /**
     * @throws Exception
     */
    public function get_eligible_resolutions(): array
    {
        $resolutions = myquery::getInstance()->getEnabledVideoResolutions();
        $eligible_resolutions = [];

        foreach ($resolutions as $key => $value) {
            $video_height = (int)$key;
            $video_width = (int)$value;

            // This option allow video with a 1% lower resolution to be included in the superior resolution
            // For example : 1900x800 will be allowed in 1080p resolution
            if (config('allow_conversion_1_percent') == 'yes') {
                $video_height_test = floor($video_height * 0.99);
                $video_width_test = floor($video_width * 0.99);
            } else {
                $video_height_test = $video_height;
                $video_width_test = $video_width;
            }

            $res = [];

            // Here we must check width and height to be able to import other formats than 16/9 (For example : 1920x800, 1800x1080, ...)
            if ($this->input_details['video_width'] >= $video_width_test || $this->input_details['video_height'] >= $video_height_test) {
                $res['video_width'] = $video_width;
                $res['video_height'] = $video_height;
                $res['height'] = $video_height;

                $eligible_resolutions[] = $res;
            }
        }

        return $eligible_resolutions;
    }

    private function get_video_rate_param($video_rate): float
    {
        $conf_vrate = config('vrate');

        if ($video_rate <= $conf_vrate) {
            $final_vrate = $video_rate;
        } else {
            $div = intdiv(max($video_rate, $conf_vrate), min($video_rate, $conf_vrate));
            if ($div == 1) {
                $final_vrate = max($video_rate, $conf_vrate) / ceil($video_rate / $conf_vrate);
            } else {
                $final_vrate = $video_rate / $div;
            }
        }
        return $final_vrate;
    }

    /**
     * @throws Exception
     */
    private function get_conversion_option($type, array $resolution = []): string
    {
        $cmd = '';
        switch ($type) {
            case 'global':
                $cmd .= ' -y';
                $cmd .= ' -hide_banner';
                break;

            case 'video_global':
                // Video Codec
                $cmd .= ' -vcodec ' . config('video_codec');
                if (config('video_codec') == 'libx264') {
                    $cmd .= ' -preset medium';
                }
                // Video Rate
                if( empty($this->frame_rate)){
                    $original_video_framerate = $this->input_details['video_rate'];
                    $framerate = self::get_video_rate_param($this->input_details['video_rate']);
                    $this->log->writeLine(date('Y-m-d H:i:s').' - Original rate : ' . $original_video_framerate . ', final rate : ' . $framerate);
                    $this->frame_rate = $framerate;
                }

                $cmd .= ' -r ' . $this->frame_rate;

                // Fix for browsers compatibility : yuv420p10le seems to be working only on Chrome like browsers
                if (config('force_8bits')) {
                    $cmd .= ' -pix_fmt yuv420p';
                }
                // Fix rare video conversion fail
                $cmd .= ' -max_muxing_queue_size 1024';
                $cmd .= ' -start_at_zero';
                break;

            case 'video_mp4':
                $final_video_bitrate = min($this->input_details['video_bitrate'], myquery::getInstance()->getVideoResolutionBitrateFromHeight($resolution['height']));

                // Video Bitrate
                $cmd .= ' -vb ' . $final_video_bitrate;
                // Keeping the original video ratio with wanted height
                if( $this->input_details['video_wh_ratio'] >= 1 ){
                    $scale = '-2:' . $resolution['video_height'];
                } else {
                    $scale = $resolution['video_height'] . ':-2';
                }
                $cmd .= ' -vf "scale=' . $scale . '"';
                break;

            case 'video_hls':
                $count = 0;
                $bitrates = '';
                $resolutions = ' -filter_complex "';
                $log_res = '';
                $filter_complex = '';
                $video_track_id = self::get_media_stream_id('video', $this->input_file);

                foreach ($resolution as $res) {
                    $video_bitrate = myquery::getInstance()->getVideoResolutionBitrateFromHeight($res['height']);
                    $this->video_files[] = $res['height'];
                    if( !empty($log_res) ){
                        $log_res .= ' & ';
                    }
                    $log_res .= $res['height'];
                    $bitrates .= ' -b:v:' . $count . ' ' . $video_bitrate;

                    if( $this->input_details['video_wh_ratio'] >= 1 ){
                        $scale = '-2:' . $res['video_height'];
                    } else {
                        $scale = $res['video_height'] . ':-2';
                    }
                    if( $filter_complex != '' ){
                        $filter_complex .= '; ';
                    }
                    $filter_complex .= '[' . $video_track_id . ':v]scale=' . $scale . '[v' . $count . ']';
                    $count++;
                }
                $resolutions .= $filter_complex . '"';

                $this->log->writeLine(date('Y-m-d H:i:s').' - Converting into '.$log_res.'...');
                $cmd .= $bitrates . $resolutions;
                break;

            case 'audio_global':
                // Audio Bitrate
                $cmd .= ' -b:a ' . config('sbrate');
                // Audio Rate
                $cmd .= ' -ar ' . config('srate');
                // Audio Codec
                $cmd .= ' -c:a ' . config('audio_codec');
                if (config('audio_codec') == 'aac') {
                    $cmd .= ' -profile:a aac_low';
                }
                // Fix for ChromeCast : Forcing stereo mode
                if (config('chromecast_fix')) {
                    $cmd .= ' -ac 2';
                }
                break;

            case 'mp4':
                $cmd .= ' -f ' . $this->conversion_type;
                $cmd .= ' -movflags faststart';
                break;

            case 'map_mp4':
                // Keeping video map
                $video_track_id = self::get_media_stream_id('video', $this->input_file);
                $cmd .= ' -map 0:' . $video_track_id;
                // Making selected audio track the primary one
                if ($this->audio_track >= 0) {
                    $cmd .= ' -map 0:' . $this->audio_track;
                }
                // Keeping audio tracks
                if (config('keep_audio_tracks')) {
                    $audio_tracks = self::get_media_stream_id('audio', $this->input_file);
                    foreach ($audio_tracks as $track_id) {
                        if ($track_id != $this->audio_track) {
                            $cmd .= ' -map 0:' . $track_id;
                        }
                    }
                }
                // Keeping subtitles
                if (config('keep_subtitles')) {
                    $subtitles = self::get_track_infos($this->input_file, 'subtitle');
                    foreach ($subtitles as $track_id => $data) {
                        if( empty($data['codec_name']) || in_array($data['codec_name'], ['hdmv_pgs_subtitle', 'dvd_subtitle']) ){
                            continue;
                        }

                        if( !$this->check_subtitle_track($track_id) ){
                            $this->log->writeLine(date('Y-m-d H:i:s').' - Subtitle track ' . $track_id . ' (' . $data['title']. ') seems corrupted and has been excluded.');
                            continue;
                        }

                        $cmd .= ' -map 0:' . $track_id;
                    }

                    if ($this->conversion_type == 'mp4') {
                        $cmd .= ' -c:s mov_text';
                    } else {
                        $cmd .= ' -c:s ' . config('subtitle_format');
                    }
                }
                break;

            case 'map_hls':
                $map = '';
                $var_stream_map = ' -var_stream_map \'';
                $count = 0;
                foreach ($resolution as $res) {
                    $map .= ' -map "[v' . $count . ']"';
                    $var_stream_map .= ' v:' . $count . ',name:video_' . myquery::getInstance()->getVideoResolutionTitleFromHeight($res['height']) . ',agroup:audios';

                    $count++;
                }

                $count = 0;
                $audio_tracks = self::get_media_stream_id('audio', $this->input_file);
                foreach ($audio_tracks as $audio_track_id) {
                    $map .= ' -map 0:' . $audio_track_id;
                    $var_stream_map .= ' a:' . $count . ',name:audio_' . ($count + 1) . ',agroup:audios';
                    if ($audio_track_id == $this->audio_track) {
                        $var_stream_map .= ',default:yes';
                    }

                    $count++;
                }

                $var_stream_map .= '\'';

                $cmd .= $map . $var_stream_map;

                break;

            case 'hls':
                $cmd .= ' -hls_time 4';
                $cmd .= ' -force_key_frames "expr:gte(t,n_forced*1)"';
                $cmd .= ' -hls_playlist_type vod';
                $cmd .= ' -master_pl_name "index.m3u8"';
                $cmd .= ' ' . $this->output_dir . '%v.m3u8';
                $this->output_file = $this->output_dir . 'index.m3u8';
                break;
        }
        return $cmd . ' ';
    }

    /**
     * @throws Exception
     */
    private function convert_hls(array $resolutions)
    {
        $command = config('ffmpegpath');
        $command .= $this->get_conversion_option('global');
        $command .= ' -i ' . $this->input_file;
        $command .= $this->get_conversion_option('video_global');
        $command .= $this->get_conversion_option('audio_global');
        $command .= $this->get_conversion_option('video_hls', $resolutions);
        $command .= $this->get_conversion_option('map_hls', $resolutions);
        $command .= $this->get_conversion_option('hls');
        $command .= ' 2>&1';

        if (in_dev()) {
            $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Command : </p><p class="content">'.$command.'</p></div>', false, true);
        }

        $output = $this->exec_with_percent($command);

        if (in_dev()) {
            $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output : </p><p class="content">'.$output.'</p></div>', false, true);
        }

        if (file_exists($this->output_file) && filesize($this->output_file) > 0 && strpos($output, 'Conversion failed!') === false) {
            $this->log->writeLine(date('Y-m-d H:i:s').' => Video converted');
        } else {
            $this->log->writeLine(date('Y-m-d H:i:s').' => Conversion failed');
        }
    }

    /**
     * Function used to convert video
     *
     * @param array $resolution
     * @throws Exception
     */
    function convert_mp4(array $resolution)
    {
        $opt_av = $this->get_conversion_option('global');
        $opt_av .= ' -i ' . $this->input_file;
        $opt_av .= $this->get_conversion_option('video_global');
        $opt_av .= $this->get_conversion_option('video_mp4', $resolution);
        $opt_av .= $this->get_conversion_option('audio_global');
        $opt_av .= $this->get_conversion_option('map_mp4');
        $opt_av .= $this->get_conversion_option('mp4');

        $this->output_file = $this->output_dir . $this->file_name . '-' . $resolution['height'] . '.' . $this->conversion_type;

        $this->log->writeLine(date('Y-m-d H:i:s').' - Converting into '.$resolution['height'].'...');
        $command = config('ffmpegpath') . $opt_av . ' ' . $this->output_file . ' 2>&1';

        if (in_dev()) {
            $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Command : </p><p class="content">'.$command.'</p></div>', false, true);
        }

        $output = $this->exec_with_percent($command, $resolution);

        if (in_dev()) {
            $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output : </p><p class="content">'.$output.'</p></div>', false, true);
        }

        if (file_exists($this->output_file) && filesize($this->output_file) > 0 && strpos($output, 'Conversion failed!') === false) {
            $this->video_files[] = $resolution['height'];
            $this->log->writeLine(date('Y-m-d H:i:s').' => Video converted');
        } else {
            $this->log->writeLine(date('Y-m-d H:i:s').' => Conversion failed !');
        }

        $this->output_details = $this->get_file_info($this->output_file);
        $this->log_ouput_file_info();
    }

    /**
     * @throws Exception
     */
    private function exec_with_percent(string $command, array $resolution = [])
    {
        if( function_exists('proc_open') ){
            $descriptorspec = [
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w']
            ];

            $process = proc_open($command, $descriptorspec, $pipes);
            $output = '';

            if (is_resource($process)) {
                stream_set_blocking($pipes[1], false);
                stream_set_blocking($pipes[2], false);

                $buffer = '';
                $duration = $this->input_details['duration'];
                $video_rate = $this->frame_rate;
                $regex = '/frame=\s*(\d+)/';

                $video_info = Video::getInstance()->getOne([
                    'file_name'                   => $this->file_name,
                    'disable_generic_constraints' => true
                ]);

                $total_current_conversion_percent = 0;
                if ($this->conversion_type == 'mp4') {
                    $total_current_conversion_percent = ($resolution['video_width'] * $resolution['video_height']) / $this->total_pixels;
                }

                $lastOutputTime = time();
                $status = proc_get_status($process);

                while (true) {
                    $stdout = stream_get_contents($pipes[1]);
                    $stderr = stream_get_contents($pipes[2]);

                    if ($stdout === false && $stderr === false && !$status['running']) {
                        break;
                    }

                    $buffer .= $stdout . $stderr;

                    $lines = preg_split('/[\r\n]+/', $buffer);
                    $buffer = array_pop($lines);

                    foreach ($lines as $line) {
                        $currentTime = time();

                        if (preg_match($regex, $line, $matches) && ($currentTime >= $lastOutputTime + 3 || !$status['running'])) {
                            $current_percent = (int)$matches[1] / ((int)$video_rate * $duration);
                            $line .= ' (' . round($current_percent * 100, 2) . ' %)';

                            if ($this->conversion_type == 'mp4') {
                                $current_percent = $this->convert_percent_done + $total_current_conversion_percent * $current_percent;
                            }

                            Video::getInstance()->set($video_info['videoid'], 'convert_percent', round($current_percent * 100, 2));
                            $lastOutputTime = time();
                        }

                        $output .= $line . PHP_EOL;
                    }

                    $status = proc_get_status($process);
                    if (!$status['running'] && feof($pipes[1]) && feof($pipes[2])) {
                        break;
                    }

                    if (!$status['running']) {
                        usleep(50000);
                    } else {
                        sleep(1);
                    }
                }

                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
            } else {
                try{
                    proc_close($process);
                }
                catch(Exception $e){}
            }
        } else {
            $output = shell_exec($command);
        }

        return $output;
    }

    function prepare()
    {
        //Checking File Exists
        if (!file_exists($this->input_file)) {
            $this->log->writeLine('File Exists', 'No');
        }

        //Get File info
        $this->input_details = $this->get_file_info($this->input_file);
        //Logging File Details
        $this->log_input_file_infos();

        switch ($this->conversion_type) {
            default:
            case 'mp4':
                $this->output_dir = DirPath::get('videos') . $this->file_directory;
                break;
            case 'hls':
                $this->output_dir = DirPath::get('videos') . $this->file_directory . $this->file_name . DIRECTORY_SEPARATOR;
                break;
        }

        if (!is_dir($this->output_dir)) {
            mkdir($this->output_dir, 0755, true);
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generateAllThumbs()
    {
        $this->log->newSection('Thumbs generation');

        $thumbs_res_settings = thumbs_res_settings_28();

        $thumbs_settings = [];
        $thumbs_settings['duration'] = $this->input_details['duration'];
        $thumbs_settings['num'] = config('num_thumbs');

        $video_info = Video::getInstance()->getOne([
            'file_name' => $this->file_name
            ,'disable_generic_constraints' => true
        ]);

        if( empty($video_info) ){
            $this->log->writeLine(date('Y-m-d H:i:s') . ' - ' . lang('technical_error'));
            return;
        }

        $thumbs_settings['videoid'] = $video_info['videoid'];

        //delete olds thumbs from db and on disk
        $this->log->writeLine(date('Y-m-d H:i:s').' - Deleting old thumbs...');
        Clipbucket_db::getInstance()->delete(tbl('video_thumbs'), ['videoid','type'], [$video_info['videoid'],'auto']);
        $pattern = DirPath::get('thumbs') . $this->file_directory . DIRECTORY_SEPARATOR . $this->file_name . '*[!-cpb].*';
        $glob = glob($pattern);
        foreach ($glob as $thumb) {
            unlink($thumb);
        }

        //reset default thumb
        $this->generateDefaultsThumbs($video_info['videoid'], $thumbs_res_settings, $thumbs_settings);
    }

    public static function extractVideoThumbnail(array $params): array
    {
        $size = '';
        if( $params['size_tag'] != 'original' ){
            $color = self::convertHexToFFmpeg(config('thumb_background_color'));
            $width = $params['width'];
            $height = $params['height'];
            $size .= '-vf "scale=\'if(gt(a,' . $width . '/' . $height . '),' . $width . ',-1)\':\'if(gt(a,' . $width . '/' . $height . '),-1,' . $height . ')\',pad=' . $width . ':' . $height . ':(' . $width . '-iw)/2:(' . $height . '-ih)/2:' . $color . '"';
        }
        $command = config('ffmpegpath') . ' -ss ' . $params['timecode'] . ' -i ' . $params['input_path'] . ' -pix_fmt yuvj422p -an -r 1 ' . $size . ' -y -f image2 -vframes 1 ' . $params['output_path'] . ' 2>&1';

        return [
            'command' => $command
            ,'output' => shell_exec($command)
        ];
    }

    /**
     * @param $array
     * @return void
     * @throws Exception
     */
    public function generateThumbs($array)
    {
        $duration = $array['duration'];
        $size_tag = $array['size_tag'];
        $num = $array['num'];

        $this->log->writeLine(date('Y-m-d H:i:s').' - Generating '.$size_tag.'...');

        if ($num > $duration) {
            $num = (int)$duration;
        }

        $thumb_dir = DirPath::get('thumbs') . $this->file_directory;
        if (!is_dir($thumb_dir)) {
            mkdir($thumb_dir, 0755, true);
        }

        $videoid = $array['videoid'];

        $extension = 'jpg';
        if ($num >= 1) {
            $division = $duration / $num;

            for ($count = 1; $count <= $num; $count++) {
                $thumb_file_number = str_pad((string)$count, 4, '0', STR_PAD_LEFT);
                $file_name = $this->file_name . '-' . $size_tag . '-' . $thumb_file_number . '.' . $extension;
                $file_path = $thumb_dir . $file_name;
                $time_sec = (int)($division * $count);

                $this->log->writeLine(date('Y-m-d H:i:s').' => Generating '.$file_name.'...');

                $return = self::extractVideoThumbnail([
                    'timecode' => $time_sec
                    ,'input_path' => $this->input_file
                    ,'size_tag' => $array['size_tag']
                    ,'width' => $array['width']
                    ,'height' => $array['height']
                    ,'output_path' => $file_path
                ]);

                if(in_dev()){
                    $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Command : </p><p class="content">'.$return['command'].'</p></div>', false, true);
                    $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output : </p><p class="content">'.$return['output'].'</p></div>', false, true);
                }

                if (file_exists($file_path)) {
                    Clipbucket_db::getInstance()->insert(tbl('video_thumbs'), ['videoid', 'resolution', 'num', 'extension', 'version', 'type'], [$videoid, $size_tag, $thumb_file_number, $extension, Update::getInstance()->getCurrentCoreVersion(), 'auto']);
                } else {
                    $this->log->writeLine(date('Y-m-d H:i:s').' => Error generating '.$file_name.'...');
                }
            }
        } else {
            $this->log->writeLine(date('Y-m-d H:i:s').' - Thumbs num can\'t be '.$num.'...');
        }
    }

    /**
     * @throws Exception
     */
    public function generateAllMissingThumbs()
    {
        $thumbs_res_settings = thumbs_res_settings_28();

        $thumbs_settings = [];
        $thumbs_settings['duration'] = $this->input_details['duration'];
        $thumbs_settings['num'] = config('num_thumbs');
        $rs = Clipbucket_db::getInstance()->select(tbl('video'), '*', 'file_name LIKE \'' . $this->file_name . '\'');

        if( empty($rs) ){
            e(lang('technical_error'));
            return;
        }

        $video_details = $rs[0];

        $thumbs_settings['videoid'] = $video_details['videoid'];

        $thumbs = get_thumb($video_details, true);
        //si rien en base
        if (empty($thumbs) || $thumbs[0] == default_thumb()) {
            Video::getInstance()->deletePictures($video_details, 'auto');

            //generate default thumb
            $this->generateDefaultsThumbs($video_details['videoid'], $thumbs_res_settings, $thumbs_settings);
        }
    }

    private function check_subtitle_track(int $track_id): bool
    {
        $cmd = config('ffmpegpath');
        $cmd .= ' -y -hide_banner';
        $cmd .= ' -loglevel error';
        $cmd .= ' -i ' . $this->input_file;
        $cmd .= ' -map 0:' . $track_id . ' -c:s mov_text';
        $cmd .= ' -f mp4 -movflags faststart+frag_keyframe+empty_moov /dev/null 2>&1';

        if (in_dev()) {
            $this->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Subtitle track ' . $track_id . ' check command : </p><p class="content">'.$cmd.'</p></div>', false, true);
        }

        $return = shell_exec($cmd);

        return empty($return);
    }

    public static function get_track_infos(string $filepath, string $type): array
    {
        $json = shell_exec(config('ffprobe_path') . ' -i "' . $filepath . '" -loglevel panic -print_format json -show_entries stream 2>&1');
        $tracks_json = json_decode($json, true)['streams'];
        $data = [];
        foreach ($tracks_json as $track) {
            if ($track['codec_type'] != $type) {
                continue;
            }

            if (!isset($track['tags'])) {
                continue;
            }

            $map_id = $track['index'];
            $tags = $track['tags'];

            if (!isset($tags['language']) && !isset($tags['LANGUAGE']) && !isset($tags['title'])) {
                continue;
            }

            $title = '';
            if (isset($tags['language'])) {
                $title .= $tags['language'];
            } else {
                if (isset($tags['LANGUAGE'])) {
                    $title .= $tags['LANGUAGE'];
                }
            }

            if (isset($tags['title'])) {
                if (!empty($title)) {
                    $title .= ' : ';
                }
                $title .= $tags['title'];
            }

            $data[$map_id]['title'] = $title;
            if (isset($track['codec_name'])) {
                $data[$map_id]['codec_name'] = $track['codec_name'];
            }

        }

        return $data;
    }

    public static function get_track_title(string $filepath, string $type)
    {
        $stats = stat($filepath);
        if ($stats && is_array($stats)) {
            $json = shell_exec(config('ffprobe_path') . ' -i "' . $filepath . '" -loglevel panic -print_format json -show_entries stream 2>&1');
            $tracks_json = json_decode($json, true)['streams'];
            $langs = [];
            foreach ($tracks_json as $track) {
                if ($track['codec_type'] != $type) {
                    continue;
                }

                if (!isset($track['tags'])) {
                    continue;
                }

                $map_id = $track['index'];
                $track = $track['tags'];

                if (!isset($track['language']) && !isset($track['LANGUAGE']) && !isset($track['title'])) {
                    continue;
                }

                $title = '';
                if (isset($track['language'])) {
                    $title .= $track['language'];
                } else {
                    if (isset($track['LANGUAGE'])) {
                        $title .= $track['LANGUAGE'];
                    }
                }

                if (isset($track['title'])) {
                    if (!empty($title)) {
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
        if (file_exists($filepath)) {
            $json = shell_exec(config('ffprobe_path') . ' -i "' . $filepath . '" -loglevel panic -print_format json -show_entries stream 2>&1');
            $tracks_json = json_decode($json, true)['streams'];
            $streams_ids = [];
            foreach ($tracks_json as $track) {
                if ($track['codec_type'] != $type) {
                    continue;
                }

                if (!isset($track['index'])) {
                    continue;
                }

                if ($type == 'video') {
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
        if ($stats && is_array($stats)) {
            $json = shell_exec(config('ffprobe_path') . ' -v quiet -print_format json -show_format -show_streams "' . $filepath . '"');
            $data = json_decode($json, true);

            $video = null;
            foreach ($data['streams'] as $stream) {
                if ($stream['codec_type'] == 'video') {
                    $video = $stream;
                    break;
                }
            }

            if ($video) {
                $info = [];
                $info['duration'] = $data['format']['duration'];
                $info['width'] = (int)$video['width'];
                $info['height'] = (int)$video['height'];
                return $info;
            }
            return [];
        }
        return [];
    }

    /**
     * @throws Exception
     */
    private function get_max_resolution_from_file(): int
    {
        $video_resolutions = myquery::getInstance()->getVideoResolutions();
        $max_resolution = 0;

        foreach ($video_resolutions as $ratio) {
            foreach ($ratio as $res) {
                $video_height = (int)$res['height'];
                $video_width = (int)$res['width'];

                // This option allow video with a 1% lower resolution to be included in the superior resolution
                // For example : 1900x800 will be allowed in 1080p resolution
                if (config('allow_conversion_1_percent') == 'yes') {
                    $video_height_test = floor($video_height * 0.99);
                    $video_width_test = floor($video_width * 0.99);
                } else {
                    $video_height_test = $video_height;
                    $video_width_test = $video_width;
                }

                // Here we must check width and height to be able to import other formats than 16/9 (For example : 1920x800, 1800x1080, ...)
                if ($this->input_details['video_width'] >= $video_width_test || $this->input_details['video_height'] >= $video_height_test) {
                    if ($video_height > $max_resolution) {
                        $max_resolution = $video_height;
                    }
                }
            }
        }

        return $max_resolution;
    }

    /**
     * @param $videoid
     * @param array $thumbs_res_settings
     * @param array $thumbs_settings
     * @return void
     * @throws Exception
     */
    public function generateDefaultsThumbs($videoid, array $thumbs_res_settings, array $thumbs_settings)
    {
        foreach ($thumbs_res_settings as $key => $thumbs_size) {
            $height_setting = $thumbs_size[1];
            $width_setting = $thumbs_size[0];

            if ($key == 'original') {
                $thumbs_settings['size_tag'] = $key;
            } else {
                $thumbs_settings['size_tag'] = $width_setting . 'x' . $height_setting;
                $thumbs_settings['width'] = $width_setting;
                $thumbs_settings['height'] = $height_setting;
            }

            $this->generateThumbs($thumbs_settings);
        }

        $res = Clipbucket_db::getInstance()->select(tbl('video') . ' AS V LEFT JOIN ' . tbl('video_thumbs') . ' AS VT ON VT.videoid = V.videoid '
            , 'num'
            , ' V.videoid = ' . mysql_clean($videoid). ' AND type=\'custom\' AND V.default_thumb = VT.num'
        );
        if (empty($res)) {
            Clipbucket_db::getInstance()->update(tbl('video'), ['default_thumb'], [1], ' videoid = ' . mysql_clean($videoid));
        }
    }

    public static function getFileType($filepath): string
    {
        $output = shell_exec(config('ffprobe_path') . ' -v quiet -print_format json -show_format -show_streams ' . escapeshellarg($filepath));
        $info = json_decode($output, true);

        if( !empty($info['format']['format_name']) && $info['format']['format_name'] == 'mpegts' ){
            return 'video/mp2t';
        }
        return '';
    }

    public static function convertHexToFFmpeg(string $hex_color): string
    {
        $hex_color = ltrim($hex_color, '#');
        if (!preg_match('/^[a-fA-F0-9]{6}$/', $hex_color)) {
            return '0x000000';
        }
        return '0x' . strtoupper($hex_color);
    }

}
