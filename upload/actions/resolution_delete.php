<?php
define('THIS_PAGE', 'resolution_delete');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$resolution = $_POST['resolution'];

$data = Video::getInstance()->getOne(['videoid' => $_POST['videoid']]);
$video_files = json_decode($data['video_files']);

if( !empty($video_files) && count($video_files) > 1 ){
    CBvideo::getInstance()->remove_resolution($resolution, $data);
} else {
    e(lang('last_video_file'));
}

$resolution_list = getResolution_list($data);
display_resolution_list($resolution_list);
