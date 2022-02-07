<?php
global $userquery,$pages,$Upload,$eh,$myquery,$cbvid;
require_once '../includes/admin_config.php';

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

$video = $_GET['video'];
$data = get_video_details($video);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = array('title' => lang('videos'), 'url' => '');
$breadcrumb[1] = array('title' => lang('videos_manager'), 'url' => ADMIN_BASEURL.'/video_manager.php');
$breadcrumb[2] = array('title' => 'Editing : '.display_clean($data['title']), 'url' => ADMIN_BASEURL.'/edit_video.php?video='.display_clean($video));

if(@$_GET['msg']){
    $msg[] = clean($_GET['msg']);
}

//Updating Video Details
if(isset($_POST['update'])) {
    $Upload->validate_video_upload_form();
    if(empty($eh->get_error())) {
        $myquery->update_video();
        $myquery->set_default_thumb($video,$_POST['default_thumb']);

        $data = get_video_details($video);
    }
}

//Performing Video Actions
if($_GET['mode']!=''){
    $modedata = $cbvid->action($_GET['mode'],$video);
    assign('modedata',$modedata);
}

//Check Video Exists or Not
if($myquery->VideoExists($video)) {
    //Deleting Comment
    $cid = mysql_clean($_GET['delete_comment']);
    if(!empty($cid)) {
        $myquery->delete_comment($cid);
    }

    Assign('udata',$userquery->get_user_details($data['userid']));

    $date_added = DateTime::createFRomFormat('Y-m-d', explode(' ',$data['date_added'])[0]);
    $data['date_added'] = $date_added->format(DATE_FORMAT);

    Assign('data',$data);
} else {
    $msg[] = lang('class_vdo_del_err');
}

$type = 'v';
$comment_cond = array();
$comment_cond['order'] = ' comment_id DESC';
$comment_cond['videoid'] = $video;
$comments = getComments($comment_cond);
assign("comments",$comments);

//Deleting comment
if(isset($_POST['del_cmt'])){
    $cid = mysql_clean($_POST['cmt_id']);
    $type_id = $myquery->delete_comment($cid);
    $cbvid->update_comments_count($type_id);
}

function format_number($number)
{
    if($number >= 1000) {
        return $number/1000 . 'k'; // NB: you will want to round this
    }
    return $number;
}

$comments = getComments($comment_cond);
assign('comments',$comments);

subtitle('Edit Video');
template_files('edit_video.html');
display_it();
