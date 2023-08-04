<?php
require_once '../includes/admin_config.php';
global $userquery, $pages, $myquery;
$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

if (@$_GET['msg']) {
    $msg[] = clean($_GET['msg']);
}

$video = mysql_clean($_GET['video']);

//Check Video Exists or Not
if ($myquery->video_exists($video)) {
    //Deleting Comment
    $cid = mysql_clean($_GET['delete_comment']);
    if (!empty($cid)) {
        $myquery->delete_comment($cid);
    }

    //Get Video Details
    $data = get_video_details($video);
    Assign('udata', $userquery->get_user_details($data['userid']));
    Assign('data', $data);
} else {
    $msg[] = lang('class_vdo_del_err');
}

Assign('msg', @$msg);

subtitle("View Video");
template_files('view_video.html');
display_it();
