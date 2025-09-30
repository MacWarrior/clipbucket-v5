<?php
class remote_play{
    /**
     * @throws Exception
     */
    function __construct(){
        if( FRONT_END ){
            $this->add_upload_form();
            $this->add_js();
        }
        $this->register_custom_upload_field();
        $this->register_custom_video_file_funcs();
    }

    /**
     * @throws Exception
     */
    private function add_upload_form(): void
    {
        ClipBucket::getInstance()->upload_opt_list['link_video_link'] = [
            'title'      => lang('remote_play'),
            'class'      => self::class,
            'function'   => 'load_form'
        ];
    }

    /**
     * @throws Exception
     */
    private function add_js(): void
    {
        if( defined('THIS_PAGE') && THIS_PAGE != 'upload' ){
            return;
        }

        $min_suffixe = System::isInDev() ? '' : '.min';
        ClipBucket::getInstance()->addJS(['pages/remote_play/remote_play' . $min_suffixe . '.js'  => 'admin']);
        ClipBucket::getInstance()->add_header(LAYOUT .'/blocks/remote_play/header.html');
    }

    /**
     * @throws Exception
     */
    private function register_custom_upload_field(): void
    {
        global $cb_columns;
        $link_vid_field_array['remote_play_url'] = [
            'title'		             => lang('remote_play_input_url'),
            'name'		             => 'remote_play_url',
            'db_field'	             => 'remote_play_url',
            'required'	             => 'no',
            'validate_function'      => self::class.'::isValidVideoURL',
            'type'	                 => 'textfield',
            'keep_original_on_error' => true
        ];

        register_custom_upload_field($link_vid_field_array);

        $cb_columns->object('videos')->add_column('remote_play_url');
        Video::getInstance()->addFields(['remote_play_url']);
    }

    private function register_custom_video_file_funcs(): void
    {
        ClipBucket::getInstance()->register_custom_video_file_func('get_video_url', self::class);
    }

    /**
     * @throws Exception
     */
    public static function load_form(): void
    {
        assign('placeholder_url', lang('remote_play_input_url_example', DirPath::getUrl('videos') . 'example.mp4'));
        Template(LAYOUT . '/blocks/remote_play/first-form.html', false);
    }

    /**
     * @throws Exception
     */
    public static function isValidVideoURL($video_url){
        if( empty($video_url) ){
            return false;
        }

        if( filter_var($video_url, FILTER_VALIDATE_URL) === FALSE ){
            e(lang('remote_play_invalid_url'));
            return false;
        }

        $extension = strtolower(getExt($video_url));
        $allowed_extensions = ['mp4','m3u8'];
        if( !in_array($extension, $allowed_extensions) ){
            e(lang('remote_play_invalid_extension'));
            return false;
        }

        $check_url = get_headers($video_url);
        if( !isset($check_url[0]) ){
            e(lang('remote_play_website_not_responding'));
            return false;
        }

        if(!str_contains($check_url[0], '200')){
            e(lang('remote_play_url_not_working'));
            return false;
        }

        return $video_url;
    }

    public static function get_video_url($video, $hq = false)
    {
        if( !empty($video['remote_play_url']) ) {
            return $video['remote_play_url'];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public static function process_file($video_url, $video_id): void
    {
        require_once DirPath::get('classes') . 'sLog.php';

        $file_directory = create_dated_folder();

        $video = Video::getInstance()->getOne(['videoid' => $video_id]);
        $logFile = DirPath::get('logs') . $file_directory . DIRECTORY_SEPARATOR . $video['file_name'] . '.log';

        $log = new SLog($logFile);
        $ffmpeg = new FFMpeg($log);

        $ffmpeg->log->newSection('Conversion lock');
        while($ffmpeg->isLocked()){
            $ffmpeg->log->writeLine(date('Y-m-d H:i:s').' - Waiting for conversion lock...');
            sleep(5);
        }
        $ffmpeg->log->writeLine(date('Y-m-d H:i:s').' - Starting conversion...');

        $video_infos = $ffmpeg->get_file_info($video_url);
        update_video_status($video['file_name'], 'Processing');
        $ffmpeg->input_details['video_width'] = $video_infos['video_width'];
        $ffmpeg->input_details['video_height'] = $video_infos['video_height'];
        $ffmpeg->file_name = $video['file_name'];
        $ffmpeg->input_file = $video_url;
        $ffmpeg->file_directory = $file_directory.DIRECTORY_SEPARATOR;
        $ffmpeg->extract_subtitles();
        $ffmpeg->input_details['duration'] = $video_infos['duration'];
        $videoThumbs = new VideoThumbs($video_id, $ffmpeg);
        $resolutions = $ffmpeg->get_eligible_resolutions();
        $max_resolution = '';
        foreach($resolutions as $res){
            if( $res['height'] > $max_resolution ){
                $max_resolution =  $res['height'];
            }
        }
        $videoThumbs->generateAutomaticThumbs();

        $fields = [
            'duration' => $video_infos['duration']
            ,'file_type' => getExt($video_url)
            ,'video_files' => '['.$max_resolution.']'
            ,'bits_color' => $video_infos['bits_per_raw_sample']
            ,'file_directory' => $file_directory
            ,'is_castable' => $video_infos['audio_channels'] <= 2 ? '1' : '0'
            ,'status' => 'Successful'
        ];

        Clipbucket_db::getInstance()->update(tbl('video'), array_keys($fields), array_values($fields), ' videoid = \''.$video_id.'\'');

        $ffmpeg->unLock();

        $ffmpeg->log->newSection('<b>Conversion Completed</b>');
    }
}