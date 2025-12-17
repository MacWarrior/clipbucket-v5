<?php
const THIS_PAGE = 'templates';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('manage_template_access', true);
pages::getInstance()->page_redir();

if (count(CBTemplate::getInstance()->get_templates()) <= 1 && !System::isInDev()) {
    redirect_to(DirPath::getUrl('admin_area'));
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('templates'))), 'url' => DirPath::getUrl('admin_area') . 'templates.php'];

if ($_GET['change']) {
    myquery::getInstance()->set_template($_GET['change']);
}

$min_in_dev = !System::isInDev() ? '.min' : '';
ClipBucket::getInstance()->addAdminJS([
    'pages/templates/templates' . $min_in_dev . '.js' => 'admin'
]);

$datepicker_js_lang = '';
if( Language::getInstance()->getLang() != 'en'){
    $datepicker_js_lang = '_languages/datepicker-'.Language::getInstance()->getLang();
}
ClipBucket::getInstance()->addAdminJS(['jquery_plugs/datepicker'.$datepicker_js_lang.'.js' => 'global']);

assign('templates', CBTemplate::getInstance()->get_templates());
subtitle('Template Manager');
template_files('templates.html');
display_it();
