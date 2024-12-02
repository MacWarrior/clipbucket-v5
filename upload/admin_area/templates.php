<?php
define('THIS_PAGE', 'templates');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $myquery, $cbtpl;
User::getInstance()->hasPermissionOrRedirect('manage_template_access', true);
$pages->page_redir();

if( count($cbtpl->get_templates()) <= 1 && !in_dev() ){
    redirect_to(BASEURL . DirPath::getUrl('admin_area'));
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('templates'))), 'url' => DirPath::getUrl('admin_area') . 'templates.php'];

if ($_GET['change']) {
    $myquery->set_template($_GET['change']);
}

subtitle('Template Manager');
template_files('templates.html');
display_it();
