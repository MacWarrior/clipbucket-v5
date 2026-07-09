<?php

User::getInstance()->hasPermissionAjax('edit_video');

$can_update = true;
$title = $_POST['title'];
if (empty($_POST['videoid']) || empty($_POST['lines'])) {
    $can_update = false;
    e(lang('missing_params'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
$video = $_POST['videoid'];
$data = Video::getInstance()->getOne(['videoid' => $video]);

if ($data['userid'] != User::getInstance()->getCurrentUserID() && !User::getInstance()->hasAdminAccess()) {
    $can_update = false;
    e(lang('insufficient_privileges'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
if ($can_update) {
    VideoAudioTrack::updateAudioTrackOrder($_POST['videoid'], $_POST['lines']);
}
assign('videoid', $data['videoid']);
$audio_track_list = VideoAudioTrack::getAudioTracks($data['videoid']);
display_audio_track_list($audio_track_list);
