<?php
const THIS_PAGE = 'resolution_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

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
