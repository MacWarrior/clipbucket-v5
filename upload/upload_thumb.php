<?php
define('THIS_PAGE', 'upload_thumb');
require 'includes/config.inc.php';

global $myquery, $Upload;

userquery::getInstance()->logincheck();

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


if ($myquery->video_exists($video)) {

    $data = get_video_details($video);
    $vid_file = DirPath::get('videos') . $data['file_directory'] . DIRECTORY_SEPARATOR . get_video_file($data, false, false);

    $is_file_to_upload= false;
    # Uploading Thumbs
    if (!empty($_FILES['vid_thumb'])) {
        $is_file_to_upload= true;
        $files = $_FILES['vid_thumb'];
        $type='c';
    }
    if (!empty($_FILES['vid_thumb_poster'])) {
        $is_file_to_upload= true;
        $files = $_FILES['vid_thumb_poster'];
        $type='p';
    }
    if (!empty($_FILES['vid_thumb_backdrop'])) {
        $is_file_to_upload= true;
        $files = $_FILES['vid_thumb_backdrop'];
        $type='b';
    }
    if ($is_file_to_upload) {
        $Upload->upload_thumbs($data['file_name'], $files, $data['file_directory'], $type);
    }
} else {
    $msg[] = lang('class_vdo_del_err');
}

redirect_to('/edit_video.php?vid=' . $data['videoid']);
