<?php
define('THIS_PAGE', 'upload_thumb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $myquery, $Upload, $pages;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

$video = mysql_clean($_GET['video']);
$data = get_video_details($video);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('videos'))), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($video)];

$allowed_types = [
    'thumbs'=>'thumbs',
    'posters'=>'poster',
    'backdrops'=>'backdrop'
];
$type = $_GET['type'] ?? $_POST['type'];
$translation_type = array_search($type, $allowed_types);
if (empty($_GET['type']) || !$translation_type) {
    e(lang('technical_error'));
    ClipBucket::getInstance()->show_page = false;
    display_it();
    die();
}

assign('type', $type);
assign('translation_type', $translation_type);
assign('db_type',array_search(( $type=='thumbs') ? 'custom': $type, Upload::getInstance()->types_thumb));

/* Complete breadcrumb */
$breadcrumb[3] = ['title' => str_replace('%s',strtolower(lang($translation_type)), lang('manage_x')), 'url' => DirPath::getUrl('admin_area') . 'upload_thumbs.php?video=' . display_clean($video) . '&type=' . display_clean($type)];

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

