<?php

User::getInstance()->hasPermissionAjax('edit_video');

if (empty($_POST['videoid']) || !isset($_POST['track_number'])) {
    e(lang('missing_params'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
$video = (int)$_POST['videoid'];
$number = (int)$_POST['track_number'];
$data = Video::getInstance()->getOne(['videoid' => $video]);

if (empty($data) || ($data['userid'] != User::getInstance()->getCurrentUserID() && !User::getInstance()->hasAdminAccess())) {
    e(lang('insufficient_privileges'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}

$success = VideoAudioTrack::deleteAudioTrack(['videoid' => $video, 'track_number' => $number]);
echo json_encode(['success' => $success, 'msg'=>getTemplateMsg()]);
