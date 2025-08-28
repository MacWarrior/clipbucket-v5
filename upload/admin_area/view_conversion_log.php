<?php
const THIS_PAGE = 'view_conversion_log';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('video_moderation', true);
pages::getInstance()->page_redir();

$file_name = $_GET['file_name'];
$data = get_basic_video_details_from_filename($file_name);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('videos'))), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($data['videoid'])];
$breadcrumb[3] = ['title' => lang('conversion_log'), 'url' => DirPath::getUrl('admin_area') . 'view_conversion_log.php?file_name=' . display_clean($file_name)];

$file_details = myquery::getInstance()->file_details($file_name);
if ($file_details) {
    $fileDetailsArray = explode("\n", $file_details);
    $file_details = implode('<br>', $fileDetailsArray);
    assign('conversion_log', $file_details);
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/view_conversion_log/view_conversion_log'.$min_suffixe.'.js' => 'admin']);

assign('videoDetails', $data);
subtitle(lang('conversion_log'));
template_files('view_conversion_log.html');
display_it();
