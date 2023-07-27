<?php
define('THIS_PAGE', 'ajax');
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

$video = $_POST['videoid'];
$number = $_POST['number'];
$title = $_POST['title'];
$data = get_video_details($video);
global $cbvideo;
$cbvideo->update_subtitle($video, $number,$title);

$subtitle_list = get_video_subtitles($data);

display_subtitle_list($subtitle_list);
