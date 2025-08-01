<?php
const THIS_PAGE = 'view_video';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('video_moderation', true);
pages::getInstance()->page_redir();

if (@$_GET['msg']) {
    $msg[] = display_clean($_GET['msg']);
}

$video = mysql_clean($_GET['video']);

//Check Video Exists or Not
if (myquery::getInstance()->video_exists($video)) {
    //Deleting Comment
    $cid = $_GET['delete_comment'];
    if (!empty($cid)) {
        Comments::delete(['comment_id' => $cid]);
    }

    //Get Video Details
    $data = get_video_details($video);
    Assign('udata', userquery::getInstance()->get_user_details($data['userid']));
    Assign('data', $data);
} else {
    $msg[] = lang('class_vdo_del_err');
}

Assign('msg', @$msg);

subtitle("View Video");
template_files('view_video.html');
display_it();
