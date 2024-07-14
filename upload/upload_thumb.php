<?php
define('THIS_PAGE', 'upload_thumb');
require 'includes/config.inc.php';

global $userquery, $myquery, $db, $Upload;

$userquery->logincheck();

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

    # Uploading Thumbs
    if (!empty($_FILES['vid_thumb'])) {
        $Upload->upload_thumbs($data['file_name'], $_FILES['vid_thumb'], $data['file_directory']);
    }
} else {
    $msg[] = lang('class_vdo_del_err');
}

redirect_to('/edit_video.php?vid=' . $data['videoid']);
