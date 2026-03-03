<?php
const THIS_PAGE = 'watch_video';
include(dirname(__FILE__, 2) . '/includes/config.inc.php');

User::getInstance()->hasPermissionOrRedirect('view_video');

if (empty($_GET['vid'])) {
    exit(lang('class_vdo_exist_err'));
}

$params = [];
$params['videokey'] = $_GET['vid'];
$params['exist'] = true;
$video_exists = Video::getInstance()->getOne($params);

if (!$video_exists) {
    exit(lang('class_vdo_exist_err'));
}

unset($params['exist']);
$video = Video::getInstance()->getOne($params);
$autoplay = $_GET['autoplay'] ?? false;

assign('video', $video);
$message = '';
$isToBlur = false;
$restricted_span = '';
if (!config('video_embed')) {
    $isToBlur = true;
    $message = lang('embed_player_disabled');
    $thumb = VideoThumbs::getDefaultMissingThumb();
} elseif (empty($video)) {
    $isToBlur = true;
    $message = lang('video_not_available');
    $thumb = VideoThumbs::getDefaultMissingThumb();
} elseif (Video::getInstance()->isToBlur($video['videoid'])) {
    $isToBlur = true;
    $message = lang(User::getInstance()->isUserConnected() ? 'error_age_restriction' : 'restrict_content_login');
    $restricted_span = '<span class="restricted" style="right: 5em; top: 3em; z-index: 110;" title="' . lang('access_forbidden_under_age', $video['age_restriction']) . '">-' . $video['age_restriction'] . '</span>';
}
if (empty($thumb)) {
    $thumb = VideoThumbs::getDefaultThumbFile($video['videoid'], '768', '480');
}
assign('isToBlur', $isToBlur);
assign('message', $message);
assign('thumb', $thumb);
assign('restricted_span', $restricted_span);
assign('autoplay', $autoplay);

Template('embed_player.html');
