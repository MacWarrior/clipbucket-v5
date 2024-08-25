<?php
define('THIS_PAGE', 'view_conversion_log');
global $pages, $myquery, $Cbucket;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

$file_name = $_GET['file_name'];
$data = get_basic_video_details_from_filename($file_name);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('videos'))), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($data['videoid'])];
$breadcrumb[3] = ['title' => 'Conversion log', 'url' => DirPath::getUrl('admin_area') . 'view_conversion_log.php?file_name=' . display_clean($file_name)];

$file_details = $myquery->file_details($file_name);
if ($file_details) {
    $fileDetailsArray = explode("\n", $file_details);
    $file_details = implode('<br>', $fileDetailsArray);
    assign('conversion_log', $file_details);
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/view_conversion_log/view_conversion_log'.$min_suffixe.'.js' => 'admin']);

assign('videoDetails', $data);
subtitle('Conversion Log');
template_files('view_conversion_log.html');
display_it();
