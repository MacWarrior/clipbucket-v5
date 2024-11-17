<?php
define('THIS_PAGE', 'subtitle_edit');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$video = $_POST['videoid'];
$number = $_POST['number'];
$title = $_POST['title'];
$data = get_video_details($video);
global $cbvideo;
$cbvideo->update_subtitle($video, $number,$title);

$subtitle_list = get_video_subtitles($data);

display_subtitle_list($subtitle_list);
