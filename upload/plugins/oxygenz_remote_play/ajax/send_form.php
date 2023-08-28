<?php
define('THIS_PAGE', 'ajax');
require_once dirname(__DIR__, 3) . '/includes/config.inc.php';

if( !has_access('allow_video_upload', true, true) ){
    echo json_encode(['error'=>lang('insufficient_privileges')]);
    die();
}

global $Upload;
if( empty($Upload->get_upload_options()) ) {
    echo json_encode(['error'=>lang('video_upload_disabled')]);
    die();
}

$step = $_POST['step'];
if( empty($step) || !in_array($step, ['check_link', 'save', 'update']) ){
    echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_invalid_step')]);
    die();
}

if( !empty($_POST['form_data']) ){
    parse_str($_POST['form_data'], $form_data);
    unset($_POST['form_data']);
    $_POST = array_merge($_POST, $form_data);
}

$video_url = $_POST['remote_play_url'] = $_POST['oxygenz_remote_play_file_url'];
unset($_POST['oxygenz_remote_play_file_url']);
if (filter_var($video_url, FILTER_VALIDATE_URL) === FALSE) {
    echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_invalid_url')]);
    die();
}

$extension = strtolower(getExt($video_url));
$allowed_extensions = ['mp4','m3u8'];
if( !in_array($extension, $allowed_extensions) ){
    echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_invalid_extension')]);
    die();
}

$check_url = get_headers($video_url);
if( !isset($check_url[0]) ){
    echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_website_not_responding')]);
    die();
}

if( strpos($check_url[0], '200') === false ){
    echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_url_not_working')]);
    die();
}

switch($step){
    case 'save':
    case 'check_link':
        require_once(dirname(__DIR__, 3) . '/includes/classes/sLog.php');
        require_once(dirname(__DIR__, 3) . '/includes/classes/conversion/ffmpeg.class.php');
        $log = new SLog();
        $ffmpeg = new FFMpeg($log);
        $video_infos = $ffmpeg->get_file_info($video_url);

        if( empty($video_infos['format']) ){
            echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_not_valid_video')]);
            die();
        }

        if( $step == 'check_link' ){
            echo json_encode(['filename'=>GetName($video_url)]);
            die();
        }

        $_POST['file_name'] = time() . RandomString(5);
        $video_id = $Upload->submit_upload();

        global $eh;
        $errors = $eh->get_error();
        if( !empty($errors) ){
            echo json_encode(['error'=>$errors[0]['val']]);
            die();
        }

        update_video_status($_POST['file_name'], 'Waiting');

        sendClientResponseAndContinue(function () use($video_id) {
            $vdetails = get_video_details($video_id);
            echo json_encode([
                'msg'       => lang('plugin_oxygenz_remote_play_video_saved')
                ,'videokey' => $vdetails['videokey']
            ]);
        });

        oxygenz_remote_play::process_file($video_url, $video_id);
        die();

    case 'update':
        unset($_POST['remote_play_url']);
        if(empty($_POST['videokey'])){
            echo json_encode(['error'=>lang('technical_error')]);
            die();
        }
        $vdetails = get_video_details($_POST['videokey']);

        if( $vdetails['userid'] != user_id() ){
            echo json_encode(['error'=>lang('plugin_oxygenz_remote_play_saving_error')]);
            die();
        }

        $_POST['file_name'] = $vdetails['file_name'];
        $Upload->submit_upload();

        global $eh;
        $errors = $eh->get_error();
        if( !empty($errors) ){
            echo json_encode(['error'=>$errors[0]['val']]);
            die();
        }

        echo json_encode(['msg'=>lang('class_vdo_update_msg')]);
        die();
}
