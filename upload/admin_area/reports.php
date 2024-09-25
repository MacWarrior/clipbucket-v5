<?php
define('THIS_PAGE', 'reports');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Reports &amp; Stats', 'url' => DirPath::getUrl('admin_area') . 'reports.php'];

$vid_dir = get_directory_size(DirPath::get('videos'));
$thumb_dir = get_directory_size(DirPath::get('thumbs'), ['.gitignore', 'processing.jpg']);
$orig_dir = get_directory_size(DirPath::get('original'));
$user_thumbs = get_directory_size(DirPath::get('avatars'));
$user_bg = get_directory_size(DirPath::get('backgrounds'));
$cat_thumbs = get_directory_size(DirPath::get('category_thumbs'));

assign('vid_dir', $vid_dir);
assign('thumb_dir', $thumb_dir);
assign('orig_dir', $orig_dir);
assign('user_thumbs', $user_thumbs);
assign('user_bg', $user_bg);
assign('cat_thumbs', $cat_thumbs);
assign('db_size', formatfilesize(get_db_size()));

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/reports/reports'.$min_suffixe.'.js' => 'admin']);
template_files('reports.html');
display_it();
