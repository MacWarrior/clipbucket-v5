<?php
const THIS_PAGE = 'subtitle_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('edit_video');

$video = $_POST['videoid'];
$number = $_POST['number'];
$data = get_video_details($video);

CBvideo::getInstance()->remove_subtitles($data, $number);
assign('videoid', $data['videoid']);
assign('vstatus', $data['status']);
$subtitle_list = get_video_subtitles($data);
display_subtitle_list($subtitle_list);
