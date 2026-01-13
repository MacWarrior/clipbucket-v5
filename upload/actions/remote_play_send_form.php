<?php
const THIS_PAGE = 'remote_play_send_form';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
    sessionMessageHandler::add_message('Sorry, you cannot upload new videos until the application has been fully updated by an administrator', 'e', User::getInstance()->getDefaultHomepageFromUserLevel());
}

if( !User::getInstance()->hasPermission('allow_video_upload') ){
    echo json_encode(['error'=>lang('insufficient_privileges')]);
    die();
}

if( empty(Upload::getInstance()->get_upload_options()) ) {
    echo json_encode(['error'=>lang('video_upload_disabled')]);
    die();
}

$step = $_POST['step'];
if( empty($step) || !in_array($step, ['check_link', 'save', 'update']) ){
    echo json_encode(['error'=>lang('remote_play_invalid_step')]);
    die();
}

if( !empty($_POST['form_data']) ){
    parse_str($_POST['form_data'], $form_data);
    unset($_POST['form_data']);
    $_POST = array_merge($_POST, $form_data);
}

$video_url = $_POST['remote_play_url'] = $_POST['remote_play_file_url'];
unset($_POST['remote_play_file_url']);
if (filter_var($video_url, FILTER_VALIDATE_URL) === FALSE) {
    echo json_encode(['error'=>lang('remote_play_invalid_url')]);
    die();
}

$extension = strtolower(getExt($video_url));
$allowed_extensions = ['mp4','m3u8'];
if( !in_array($extension, $allowed_extensions) ){
    echo json_encode(['error'=>lang('remote_play_invalid_extension')]);
    die();
}

$check_url = get_headers($video_url);
if( !isset($check_url[0]) ){
    echo json_encode(['error'=>lang('remote_play_website_not_responding')]);
    die();
}

if(!str_contains($check_url[0], '200')){
    echo json_encode(['error'=>lang('remote_play_url_not_working')]);
    die();
}

switch($step){
    case 'save':
    case 'check_link':
        require_once DirPath::get('classes') . 'sLog.php';
        $log = new SLog();
        $ffmpeg = new FFMpeg($log);
        $video_infos = $ffmpeg->get_file_info($video_url);

        if( empty($video_infos['format']) ){
            $not_valid_format = lang('remote_play_not_valid_video');
            if ($step == 'check_link') {
                echo json_encode(['error'=>$not_valid_format]);
                die();
            } else {
                e($not_valid_format);
            }
        }

        if( $step == 'check_link' ){
            echo json_encode(['filename'=>GetName($video_url)]);
            die();
        }

        $_POST['file_name'] = time() . RandomString(5);
        $video_id = Upload::getInstance()->submit_upload();

        $errors = errorhandler::getInstance()->get_error();
        if (empty($errors)) {
            if ( !empty($_POST['default_thumb'])) {
                Video::getInstance()->setDefaultPicture($video_id, $_POST['default_thumb'], 'thumbnail');
            }
            if (config('enable_video_poster') == 'yes' && !empty($_POST['default_poster'])) {
                Video::getInstance()->setDefaultPicture($video_id, $_POST['default_poster'], 'poster');
            }
            if (config('enable_video_backdrop') == 'yes' && !empty($_POST['default_backdrop'])) {
                Video::getInstance()->setDefaultPicture($video_id, $_POST['default_backdrop'], 'backdrop');
            }
        }
        $response = [];
        if( empty($errors) ) {
            e(lang('remote_play_video_saved'), 'm');
            update_video_status($_POST['file_name'], 'Waiting');
        } else {
            $response['error'] = 1;
        }
        $response['msg'] =getTemplateMsg();


        sendClientResponseAndContinue(function () use($video_id, $response) {
            $video = Video::getInstance()->getOne(['video_id' => $video_id]);
            $response['videokey'] = $video['videokey'];
            $response['videoid'] = $video_id;
            echo json_encode($response);
        });

        remote_play::process_file($video_url, $video_id);
        die();

    case 'update':
        unset($_POST['remote_play_url']);
        if(empty($_POST['videokey'])){
            echo json_encode(['error'=>lang('technical_error')]);
            die();
        }
        $vdetails = get_video_details($_POST['videokey']);

        if( $vdetails['userid'] != user_id() ){
            echo json_encode(['error'=>lang('remote_play_saving_error')]);
            die();
        }

        $_POST['file_name'] = $vdetails['file_name'];
        Upload::getInstance()->submit_upload();

        $response = [];
        $errors = errorhandler::getInstance()->get_error();
        if( empty($errors) ) {
            e(lang('class_vdo_update_msg'), 'm');
        } else {
            $response['error'] = 1;
        }
        $response['msg'] =getTemplateMsg();
        echo json_encode($response);
        die();
}
