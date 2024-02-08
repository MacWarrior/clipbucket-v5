<?php
define('THIS_PAGE', 'edit_video');
global $userquery, $pages, $Upload, $eh, $myquery, $cbvid, $breadcrumb;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

$video = $_GET['video'];

//Updating Video Details
if (isset($_POST['update'])) {
    $Upload->validate_video_upload_form();
    if (empty($eh->get_error())) {
        $myquery->update_video();
        $myquery->set_default_thumb($video, $_POST['default_thumb']);

    }
}
$data = Video::getInstance()->getOne(['videoid'=>$video]);

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('videos_manager'), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($video)];

if (@$_GET['msg']) {
    $msg[] = clean($_GET['msg']);
}

//Performing Video Actions
if ($_GET['mode'] != '') {
    $modedata = $cbvid->action($_GET['mode'], $video);
    assign('modedata', $modedata);
}


//Check Video Exists or Not
if ($myquery->video_exists($video)) {
    //Deleting Comment
    $cid = $_GET['delete_comment'];
    if (!empty($cid)) {
        Comments::delete(['comment_id' => $cid]);
    }

    assign('udata', $userquery->get_user_details($data['userid']));

    $date_added = DateTime::createFRomFormat('Y-m-d', explode(' ', $data['date_added'])[0]);
    $data['date_added'] = $date_added->format(DATE_FORMAT);

    assign('data', $data);
    assign('vidthumbs', get_thumb($data,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($data,TRUE,'168x105','custom'));

    if ($data['file_server_path']) {
        $file = $data['file_server_path'] . '/logs/' . $data['file_directory'] . $data['file_name'] . '.log';
    } else {
        $str = $data['file_directory'] . DIRECTORY_SEPARATOR;
        $file = DirPath::get('logs') . $str . $data['file_name'] . '.log';
    }
    assign('has_log', file_exists($file));
} else {
    //add parameter to display message after redirect
    redirect_to(BASEURL . DirPath::getUrl('admin_area') . 'video_manager.php?missing_video=1');
}

$resolution_list = getResolution_list($data);
assign('resolution_list', $resolution_list);

$subtitle_list = get_video_subtitles($data) ?: [];
assign('subtitle_list', $subtitle_list);

//Deleting comment
if (isset($_POST['del_cmt'])) {
    Comments::delete(['comment_id' => $_POST['cmt_id']]);
}

$params = [];
$params['type'] = 'v';
$params['type_id'] = $video;
$params['order'] = ' comment_id DESC';
$comments = Comments::getAll($params);
assign('comments', $comments);

function format_number($number)
{
    if ($number >= 1000) {
        return $number / 1000 . 'k'; // NB: you will want to round this
    }
    return $number;
}

if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
ClipBucket::getInstance()->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/edit_video/edit_video' . $min_suffixe . '.js'       => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);

$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags',$available_tags);

$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags',$available_tags);

subtitle('Edit Video');
template_files('edit_video.html');
display_it();
