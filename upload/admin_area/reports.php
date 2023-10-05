<?php
global $userquery, $Cbucket, $breadcrumb;
require_once '../includes/admin_config.php';
$userquery->admin_login_check();
$userquery->login_check('web_config_access');

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Reports &amp; Stats', 'url' => ADMIN_BASEURL . '/reports.php'];

$vid_dir = get_directory_size(VIDEOS_DIR);
$thumb_dir = get_directory_size(THUMBS_DIR, ['.gitignore', 'processing.jpg']);
$orig_dir = get_directory_size(ORIGINAL_DIR);
$user_thumbs = get_directory_size(USER_THUMBS_DIR);
$user_bg = get_directory_size(USER_BG_DIR);
$cat_thumbs = get_directory_size(CAT_THUMB_DIR);

assign('vid_dir', $vid_dir);
assign('thumb_dir', $thumb_dir);
assign('orig_dir', $orig_dir);
assign('user_thumbs', $user_thumbs);
assign('user_bg', $user_bg);
assign('cat_thumbs', $cat_thumbs);
assign('db_size', formatfilesize(get_db_size()));


if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addAdminJS(['pages/reports/reports'.$min_suffixe.'.js' => 'admin']);
template_files('reports.html');
display_it();
