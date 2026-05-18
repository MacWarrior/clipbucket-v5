<?php
const THIS_PAGE = 'subtitle_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('edit_video');

$video = $_POST['videoid'];
$number = $_POST['number'];
$data = Video::getInstance()->getOne(['videoid' => $video]);
if ($data['userid'] != User::getInstance()->getCurrentUserID() && !User::getInstance()->hasAdminAccess()) {
    e(lang('insufficient_privileges'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
CBvideo::getInstance()->remove_subtitles($data, $number);
assign('videoid', $data['videoid']);
assign('vstatus', $data['status']);
$subtitle_list = get_video_subtitles($data);
display_subtitle_list($subtitle_list);
