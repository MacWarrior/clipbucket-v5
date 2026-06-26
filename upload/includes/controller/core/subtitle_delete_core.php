<?php

User::getInstance()->hasPermissionAjax('edit_video');

$video = $_POST['videoid'];
$number = $_POST['number'];
$data = Video::getInstance()->getOne(['videoid' => $video]);
if ($data['userid'] != User::getInstance()->getCurrentUserID() && !User::getInstance()->hasAdminAccess()) {
    e(lang('insufficient_privileges'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
Subtitle::removeSubtitles($data, $number);
assign('videoid', $data['videoid']);
assign('vstatus', $data['status']);
$subtitle_list = Subtitle::getVideoSubtitles($data);
display_subtitle_list($subtitle_list);
