<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

$video = $_POST['videoid'];
$resolution = $_POST['resolution'];
$data = get_video_details($video);
global $cbvideo;
if (count(json_decode($data['video_files'])) <= 1) {
    e(lang('last_video_file'));
} else {
    $cbvideo->remove_resolution($resolution, $data);
}

$resolution_list = getResolution_list($data);

display_resolution_list($resolution_list);