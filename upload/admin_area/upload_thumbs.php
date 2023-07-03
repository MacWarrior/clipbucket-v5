<?php
define('THIS_PAGE', 'upload_thumb');
require_once '../includes/admin_config.php';

global $userquery, $myquery, $db, $Upload, $pages;

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

$video = mysql_clean($_GET['video']);
$data = get_video_details($video);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('videos_manager'), 'url' => ADMIN_BASEURL . '/video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => ADMIN_BASEURL . '/edit_video.php?video=' . display_clean($video)];
$breadcrumb[3] = ['title' => 'Manage Video Thumbs', 'url' => ADMIN_BASEURL . '/upload_thumbs.php?video=' . display_clean($video)];

if (@$_GET['msg']) {
    $msg[] = clean($_GET['msg']);
}

//Check Video Exists or Not
if ($myquery->VideoExists($video)) {
    # Setting Default thumb
    if (isset($_POST['update_default_thumb'])) {
        $myquery->set_default_thumb($video, $_POST['default_thumb']);
        $data = get_video_details($video);
    }

    $vid_file = VIDEOS_DIR . DIRECTORY_SEPARATOR . $data['file_directory'] . DIRECTORY_SEPARATOR . get_video_file($data, false, false);

    # Uploading Thumbs
    if (isset($_POST['upload_thumbs'])) {
        $Upload->upload_thumbs($data['file_name'], $_FILES['vid_thumb'], $data['file_directory'], $data['thumbs_version']);
    }

    Assign('data', $data);
    Assign('rand', rand(44, 444));
} else {
    $msg[] = lang('class_vdo_del_err');
}
foreach ($msg as $ms) {
    e($ms, 'm');
}
subtitle('Video Thumbs Manager');
template_files('upload_thumbs.html');
display_it();
