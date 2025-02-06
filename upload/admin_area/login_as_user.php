<?php
define('THIS_PAGE', 'login_as_user');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages;

if (!userquery::getInstance()->is_admin_logged_as_user()) {
    User::getInstance()->hasPermissionOrRedirect('member_moderation',true);
}
$pages->page_redir();

if ($_GET['revert']) {
    userquery::getInstance()->revert_from_user();
    redirect_to('/admin_area');
}
$uid = $_GET['uid'];

$udetails = userquery::getInstance()->get_user_details(user_id());
$userLevel = $udetails['level'];

$userToLoginAsDetails = userquery::getInstance()->get_user_details($uid);
$userToLoginAsLevel = $userToLoginAsDetails['level'];

if ($userLevel > 1 && $userToLoginAsLevel == 1) {
    e('You do not have enough permissions to login as Admin user');
}

if (userquery::getInstance()->login_as_user($uid)) {
    redirect_to(Network::get_server_url());
}
display_it();
