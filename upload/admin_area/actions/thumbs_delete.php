<?php
const THIS_PAGE = 'delete_thumbs';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
    e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}

$image = VideoThumbs::getOne(['id_video_image' => $_POST['id_video_image'], 'get_is_default'=>true]);
$data = Video::getInstance()->getOne(['videoid'=>$image['videoid']]);
VideoThumbs::deleteVideoImage($image);
display_thumb_list($data, $image['type']);
