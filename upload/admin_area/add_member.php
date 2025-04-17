<?php
define('THIS_PAGE', 'add_member');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('member_moderation', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('users'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Add Member', 'url' => DirPath::getUrl('admin_area') . 'add_member.php'];

if (isset($_POST['add_member'])) {
    if (userquery::getInstance()->signup_user($_POST)) {
        e(lang('new_mem_added'), 'm');
        $_POST = '';
    }
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/add_member/add_member'.$min_suffixe.'.js' => 'admin']);
$datepicker_js_lang = '';
if( Language::getInstance()->getLang() != 'en'){
    $datepicker_js_lang = '_languages/datepicker-'.Language::getInstance()->getLang();
}
ClipBucket::getInstance()->addAdminJS(['jquery_plugs/datepicker'.$datepicker_js_lang.'.js' => 'global']);
ClipBucket::getInstance()->addAdminCSS(['jquery_ui/jquery_ui' . $min_suffixe . '.css' => 'libs']);

subtitle('Add New Member');
template_files('add_members.html');
display_it();
