<?php
const THIS_PAGE = 'login_as_user';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
User::getInstance()->hasPermissionOrRedirect('member_moderation',true);

$uid = (int)$_GET['uid'];

$udetails = userquery::getInstance()->get_user_details(User::getInstance()->getCurrentUserID());
$userLevel = $udetails['level'];

$userToLoginAsDetails = userquery::getInstance()->get_user_details($uid);
$userToLoginAsLevel = $userToLoginAsDetails['level'];

if ($userLevel > 1 && $userToLoginAsLevel == 1) {
    SessionMessageHandler::add_message('You do not have enough permissions to login as Admin user', 'w');
    User::redirectAfterLogin();
}

if (userquery::getInstance()->login_as_user($uid)) {
    if ($_COOKIE['pageredir']) {
        unset($_COOKIE['pageredir']);
    }
    User::redirectAfterLogin();
}
display_it();
