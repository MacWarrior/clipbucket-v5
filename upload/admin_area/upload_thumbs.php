<?php
define('THIS_PAGE', 'upload_thumb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $userquery, $myquery, $db, $Upload, $pages;

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

$video = mysql_clean($_GET['video']);
$data = get_video_details($video);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('videos_manager'), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($video)];
$breadcrumb[3] = ['title' => 'Manage Video Thumbs', 'url' => DirPath::getUrl('admin_area') . 'upload_thumbs.php?video=' . display_clean($video)];

if (@$_GET['msg']) {
    $msg[] = display_clean($_GET['msg']);
}

//Check Video Exists or Not
if ($myquery->video_exists($video)) {
    # Setting Default thumb
    if (isset($_POST['update_default_thumb'])) {
        $myquery->set_default_thumb($video, $_POST['default_thumb']);
        $data = get_video_details($video);
    }

    $vid_file = DirPath::get('videos') . $data['file_directory'] . DIRECTORY_SEPARATOR . get_video_file($data, false, false);

    # Uploading Thumbs
    if (isset($_POST['upload_thumbs'])) {
        $Upload->upload_thumbs($data['file_name'], $_FILES['vid_thumb'], $data['file_directory']);
    }

    assign('data', $data);
    assign('vidthumbs', get_thumb($data,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($data,TRUE,'168x105','custom'));
} else {
    $msg[] = lang('class_vdo_del_err');
}
foreach ($msg as $ms) {
    e($ms, 'm');
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

ClipBucket::getInstance()->addAdminJS(['pages/upload_thumbs/upload_thumbs'.$min_suffixe.'.js' => 'admin']);

subtitle('Video Thumbs Manager');
template_files('upload_thumbs.html');
display_it();

