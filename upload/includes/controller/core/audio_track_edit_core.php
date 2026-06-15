<?php

User::getInstance()->hasPermissionAjax('edit_video');

$can_update = true;
$title = $_POST['title'];
if (empty($_POST['videoid']) || !isset($_POST['track_number']) || empty($_POST['title'])) {
    $can_update = false;
    e(lang('missing_params'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
$video = $_POST['videoid'];
$number = $_POST['track_number'];
$data = Video::getInstance()->getOne(['videoid' => $video]);

if ($data['userid'] != User::getInstance()->getCurrentUserID() && !User::getInstance()->hasAdminAccess()) {
    $can_update = false;
    e(lang('insufficient_privileges'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
if ($can_update) {
    Video::getInstance()->saveAudioTrack(['videoid'=>$video, 'track_number'=>$number, 'title'=>$title]);
}
assign('videoid', $data['videoid']);
$audio_track_list = Video::getInstance()->getAudioTracks($data['videoid']);
display_audio_track_list($audio_track_list);
