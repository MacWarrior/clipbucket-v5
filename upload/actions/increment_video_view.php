<?php
const THIS_PAGE = 'increment_video_view';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('view_video');

$video_key = ($_POST['video_key'] ?? '');
if( empty($video_key) ){
    echo json_encode(['success' => false]);
    exit;
}

$video = Video::getInstance()->getOne(['videokey' => $video_key]);
if( empty($video) ){
    echo json_encode(['success' => false]);
    exit;
}

if( !video_playable($video) ){
    echo json_encode(['success' => false]);
    exit;
}

if( !increment_views($video, 'video') ){
    echo json_encode(['success' => false]);
    exit;
}

echo json_encode(['success' => true]);
