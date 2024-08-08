<?php
define('THIS_PAGE', 'upload_thumb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $myquery, $db, $Upload, $pages;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

$allowed_types = [
    'thumbs',
    'poster',
    'backdrop'
];
if (empty($_GET['type']) || !in_array($_GET['type'], $allowed_types)) {
    e(lang('error'));
}
$type = $_GET['type'] ?? $_POST['type'];
assign('type', $type);
assign('db_type',array_search(( $type=='thumbs') ? 'custom': $type, Upload::getInstance()->types_thumb));
$video = mysql_clean($_GET['video']);
$data = get_video_details($video);
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('videos_manager'), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($video)];
$breadcrumb[3] = ['title' => str_replace('%s',strtolower(lang($type)), lang('manage_x')), 'url' => DirPath::getUrl('admin_area') . 'upload_thumbs.php?video=' . display_clean($video) . '&type=' . display_clean($type)];

if (@$_GET['msg']) {
    $msg[] = display_clean($_GET['msg']);
}


$can_sse = System::can_sse() ? 'true' : 'false';
assign('can_sse', $can_sse);
//Check Video Exists or Not
if ($myquery->video_exists($video)) {

    # Uploading Thumbs
    if (isset($_POST['upload_thumbs'])) {
        $Upload->upload_thumbs($data['file_name'], $_FILES['vid_thumb'], $data['file_directory'], $_POST['db_type']);
    }

    assign('data', $data);
    if ($type=='thumbs') {
        assign('vidthumbs', get_thumb($data,TRUE,'168x105','auto'));
        assign('vidthumbs_custom', get_thumb($data,TRUE,'168x105','custom'));
    } else {
        assign('vidthumbs', get_thumb($data,TRUE,false,$type));
    }
} else {
    $msg[] = lang('class_vdo_del_err');
}
foreach ($msg as $ms) {
    e($ms, 'm');
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/upload_thumbs/upload_thumbs'.$min_suffixe.'.js' => 'admin']);

subtitle(str_replace('%s',strtolower(lang($type)), lang('manage_x')));
template_files('upload_thumbs.html');
display_it();

