<?php
const THIS_PAGE = 'upload_thumb';
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('allow_video_upload', true);

if (@$_GET['msg']) {
    $msg[] = display_clean($_GET['msg']);
}

$video = mysql_clean($_GET['video']);

//Check Video Exists or Not

if (myquery::getInstance()->video_exists($video)) {

    $data = Video::getInstance()->getOne(['videoid'=>$video]);

    $is_file_to_upload= false;
    # Uploading Thumbs
    if (!empty($_FILES['vid_thumb'])) {
        $is_file_to_upload= true;
        $files = $_FILES['vid_thumb'];
        $type='thumbnail';
    }
    if (!empty($_FILES['vid_thumb_poster'])) {
        $is_file_to_upload= true;
        $files = $_FILES['vid_thumb_poster'];
        $type='poster';
    }
    if (!empty($_FILES['vid_thumb_backdrop'])) {
        $is_file_to_upload= true;
        $files = $_FILES['vid_thumb_backdrop'];
        $type='backdrop';
    }
    if ($is_file_to_upload) {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
            SessionMessageHandler::add_message('Sorry, you cannot perform this action until the application has been fully updated by an administrator', 'e');
        } else {
            VideoThumbs::uploadThumbs($data['videoid'], $files, $type, false);
        }
    }
} else {
    echo json_encode(['error'=>lang('class_vdo_del_err')]);
    die();
}
if (!empty($_POST['return_type']) && $_POST['return_type'] == 'html') {
    //refresh
    $data = Video::getInstance()->getOne(['videoid'=>$video]);
    echo json_encode(Upload::displayVideoThumbsForm($data));
} else {
    echo json_encode(['redirect'=>DirPath::getUrl('root') . 'edit_video.php?vid=' . $data['videoid']]);
}
