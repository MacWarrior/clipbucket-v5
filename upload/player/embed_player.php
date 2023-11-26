<?php
define('THIS_PAGE', 'watch_video');
include(dirname(__FILE__, 2) . '/includes/config.inc.php');

if (!userquery::getInstance()->perm_check('view_video', true)) {
    exit(lang('you_dont_hv_perms'));
}

if(empty($_GET['vid'])){
    exit(lang('class_vdo_exist_err'));
}

$params = [];
$params['videokey'] = $_GET['vid'];
$params['exist'] = true;
$video_exists = Video::getInstance()->getOne($params);

if(!$video_exists){
    exit(lang('class_vdo_exist_err'));
}

unset($params['exist']);
$video = Video::getInstance()->getOne($params);

if(!$video){
    exit(lang('video_not_available'));
}

$autoplay = $_GET['autoplay'] ?? false;

assign('video', $video);
assign('autoplay', $autoplay);

Template('embed_player.html');
