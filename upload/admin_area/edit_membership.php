<?php
define('THIS_PAGE', 'membership_user_levels');
global $pages, $Upload, $eh, $myquery, $cbvid, $breadcrumb;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */


//TODO check inputs required etc.
if (!empty($_POST['id_membership'])) {
    if (Membership::getInstance()->update($_POST)) {
        e(lang('user_level_successfully_saved'),'m');
    }
} elseif (!empty($_POST)) {
    if (Membership::getInstance()->insert($_POST)) {
        e(lang('user_level_successfully_saved'),'m');
    }
    SessionMessageHandler::add_message('user_level_successfully_saved', 'm', BASEURL . DirPath::getUrl('admin_area') . '/memberships.php');
}

$membership = Membership::getInstance()->getOne(['id_membership' => $_REQUEST['id_membership'] ?? 0]);
assign('membership', $membership);
assign('frequencies', Membership::getInstance()->getFrequencies());
assign('user_levels', userquery::getInstance()->get_levels() ?: []);

global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('memberships'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('user_levels'),
    'url'   => DirPath::getUrl('admin_area') . 'memberships.php'
];
$titre = lang((!empty($membership) ? 'edit_' : 'add_') . 'membership');
$breadcrumb[2] = [
    'title' => $titre,
    'url'   => DirPath::getUrl('admin_area') . 'edit_membership.php' . (!empty($membership) ? '?id_membership=' . $membership['id_membership'] : '')
];

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'pages/membership/edit_membership' . $min_suffixe . '.js' => 'admin',
]);
subtitle($titre);
template_files('edit_membership.html');
display_it();
