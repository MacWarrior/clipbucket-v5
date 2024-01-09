<?php
define('THIS_PAGE', 'view_conversion_log');
global $userquery, $pages, $myquery, $Cbucket;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

$file_name = $_GET['file_name'];
$data = get_basic_video_details_from_filename($file_name);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('videos_manager'), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['title']), 'url' => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . display_clean($data['videoid'])];
$breadcrumb[3] = ['title' => 'Conversion log', 'url' => DirPath::getUrl('admin_area') . 'view_conversion_log.php?file_name=' . display_clean($file_name)];

$file_details = $myquery->file_details($file_name);
if ($file_details) {
    $fileDetailsArray = explode("\n", $file_details);
    $file_details = implode('<br>', $fileDetailsArray);
    assign('conversion_log', $file_details);
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
ClipBucket::getInstance()->addAdminJS(['pages/view_conversion_log/view_conversion_log'.$min_suffixe.'.js' => 'admin']);

assign('videoDetails', $data);
subtitle('Conversion Log');
template_files('view_conversion_log.html');
display_it();
