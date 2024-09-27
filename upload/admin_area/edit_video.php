<?php
define('THIS_PAGE', 'edit_video');
global $pages, $Upload, $eh, $myquery, $cbvid, $breadcrumb;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

$video_id = $_GET['video'];

//Updating Video Details
if (isset($_POST['update'])) {
    $Upload->validate_video_upload_form();
    if (empty($eh->get_error())) {
        $myquery->update_video();
        Video::getInstance()->setDefaultPicture($video_id, $_POST['default_thumb']?? '');

        if( config('enable_video_poster') == 'yes' ){
            Video::getInstance()->setDefaultPicture($video_id, $_POST['default_poster'] ?? '', 'poster');
        }

        if( config('enable_video_backdrop') == 'yes' ) {
            Video::getInstance()->setDefaultPicture($video_id, $_POST['default_backdrop'] ?? '', 'backdrop');
        }
    }
}
$data = Video::getInstance()->getOne(['videoid'=>$video_id]);

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('videos'))), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($video_id)];

if (@$_GET['msg']) {
    $msg[] = display_clean($_GET['msg']);
}

//Performing Video Actions
if ($_GET['mode'] != '') {
    $modedata = $cbvid->action($_GET['mode'], $video_id);
    assign('modedata', $modedata);
}

//Check Video Exists or Not
if ($myquery->video_exists($video_id)) {

    assign('udata', userquery::getInstance()->get_user_details($data['userid']));

    $date_added = DateTime::createFRomFormat('Y-m-d', explode(' ', $data['date_added'])[0]);
    $data['date_added'] = $date_added->format(DATE_FORMAT);

    assign('data', $data);
    assign('vidthumbs', get_thumb($data,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($data,TRUE,'168x105','custom'));

    if( config('enable_video_poster') == 'yes' ){
        assign('vidthumbs_poster', get_thumb($data,TRUE,'original','poster'));
    }

    if( config('enable_video_backdrop') == 'yes' ) {
        assign('vidthumbs_backdrop', get_thumb($data, TRUE, 'original', 'backdrop'));
    }

    if ($data['file_server_path']) {
        $file = $data['file_server_path'] . '/logs/' . $data['file_directory'] . $data['file_name'] . '.log';
    } else {
        $str = $data['file_directory'] . DIRECTORY_SEPARATOR;
        $file = DirPath::get('logs') . $str . $data['file_name'] . '.log';
    }
    assign('has_log', file_exists($file));

    $results = Video::getInstance()->getVideoViewHistory($video_id, 1);
    pages::getInstance()->paginate($results['total_pages'], 1, 'javascript:pageViewHistory(#page#, ' . $video_id . ');');
    assign('results', $results['final_results']);
    assign('modal', false);

} else {
    //add parameter to display message after redirect
    if ($_GET['mode'] == 'delete') {
        sessionMessageHandler::add_message(lang('video_deleted'), 'm',  BASEURL . DirPath::getUrl('admin_area') . 'video_manager.php');
    }
    sessionMessageHandler::add_message(lang('class_vdo_del_err'), 'e',  BASEURL . DirPath::getUrl('admin_area') . 'video_manager.php');
}

$resolution_list = getResolution_list($data);
assign('resolution_list', $resolution_list);

$subtitle_list = get_video_subtitles($data) ?: [];
assign('subtitle_list', $subtitle_list);

//Deleting comment
if (isset($_POST['del_cmt'])) {
    Comments::delete(['comment_id' => $_POST['cmt_id']]);
}

assign('uploader_info', User::getInstance()->getOne(['userid'=>$data['userid']]));

$params = [];
$params['type'] = 'v';
$params['type_id'] = $video_id;
$params['order'] = ' comment_id DESC';
$comments = Comments::getAll($params);
assign('comments', $comments);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/edit_video/edit_video' . $min_suffixe . '.js'       => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags',$available_tags);

$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags',$available_tags);

assign('link_user', DirPath::getUrl('admin_area') . 'view_user.php?uid=' . $data['userid']);

subtitle('Edit Video');
template_files('edit_video.html');
display_it();
