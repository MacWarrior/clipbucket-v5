<?php
define('THIS_PAGE', 'photo_manager');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('photos_moderation', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('email_template_management'), 'url' => DirPath::getUrl('admin_area') . 'email_template_management.php'];

// Creating Limit
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$params['limit'] = $get_limit;


$total_pages = count_pages($total_rows, config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/email_templates/email_template'.$min_suffixe.'.js' => 'admin']);

subtitle(lang('manage_x', strtolower(lang('photos'))));
template_files('email_template_management.html');
display_it();
