<?php
define('THIS_PAGE', 'getVideoDetails');
include(dirname(__FILE__, 2) . '/includes/config.inc.php');

if(empty($_POST['vid'])){
    echo json_encode(['video' => false]);
    die();
}

if (!userquery::getInstance()->perm_check('view_video', true)) {
    echo json_encode(['video' => false]);
    die();
}

$vid = $_POST['vid'];
$video = CBvideo::getInstance()->get_video($vid);

if( !video_playable($video) ) {
    echo json_encode(['video' => false]);
    die();
}

echo json_encode($video);
