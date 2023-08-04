<?php
define('THIS_PAGE', 'upload_thumb');
require 'includes/config.inc.php';

global $userquery, $myquery, $db, $Upload;

$userquery->logincheck();

if (@$_GET['msg']) {
    $msg[] = clean($_GET['msg']);
}

$video = mysql_clean($_GET['video']);

//Check Video Exists or Not
/**
 * @param $data
 * @param Clipbucket_db $db
 * @return void
 */


if ($myquery->video_exists($video)) {
    # Setting Default thumb
    if (isset($_POST['update_default_thumb'])) {
        $myquery->set_default_thumb($video, $_POST['default_thumb']);
    }

    $data = get_video_details($video);
    $vid_file = VIDEOS_DIR . DIRECTORY_SEPARATOR . $data['file_directory'] . DIRECTORY_SEPARATOR . get_video_file($data, false, false);

    # Uploading Thumbs
    if (isset($_POST['upload_thumbs'])) {
        $Upload->upload_thumbs($data['file_name'], $_FILES['vid_thumb'], $data['file_directory'], $data['thumbs_version']);
    }
} else {
    $msg[] = lang('class_vdo_del_err');
}

redirect_to('/edit_video.php?vid=' . $data['videoid']);
