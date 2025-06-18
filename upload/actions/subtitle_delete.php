<?php
define('THIS_PAGE', 'subtitle_delete');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$video = $_POST['videoid'];
$number = $_POST['number'];
$data = get_video_details($video);

CBvideo::getInstance()->remove_subtitles($data, $number);

$subtitle_list = get_video_subtitles($data);
display_subtitle_list($subtitle_list);
