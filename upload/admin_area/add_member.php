<?php
require_once '../includes/admin_config.php';

global $userquery, $pages;

$userquery->admin_login_check();
$userquery->login_check('member_moderation');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('users'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Add Member', 'url' => DirPath::getUrl('admin_area') . 'add_member.php'];

if (isset($_POST['add_member'])) {
    if ($userquery->signup_user($_POST)) {
        e(lang('new_mem_added'), 'm');
        $_POST = '';
    }
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

ClipBucket::getInstance()->addAdminJS(['pages/add_member/add_member'.$min_suffixe.'.js' => 'admin']);

subtitle('Add New Member');
template_files('add_members.html');
display_it();
