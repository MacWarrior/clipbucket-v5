<?php
const THIS_PAGE = 'upload_thumb';
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('allow_video_upload', true);

if (@$_GET['msg']) {
    $msg[] = display_clean($_GET['msg']);
}

$video = mysql_clean($_GET['video']);

//Check Video Exists or Not
/**
 * @param $data
 * @param Clipbucket_db $db
 * @return void
 */


if (myquery::getInstance()->video_exists($video)) {

    $data = get_video_details($video);

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
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            SessionMessageHandler::add_message('Sorry, you cannot perform this action until the application has been fully updated by an administrator', 'e');
        } else {
            VideoThumbs::uploadThumbs($data['videoid'], $files, $type, false);
        }
    }
} else {
    $msg[] = lang('class_vdo_del_err');
}

echo json_encode(['redirect'=>DirPath::getUrl('root') . 'edit_video.php?vid=' . $data['videoid']]);
