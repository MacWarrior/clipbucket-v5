<?php
const THIS_PAGE = 'login_as_user';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
User::getInstance()->hasPermissionOrRedirect('member_moderation',true);

$uid = (int)$_GET['uid'];

if (!UserLevel::canLogAsUser(User::getInstance()->getCurrentUserID(), $uid)) {
    SessionMessageHandler::add_message(lang('you_dont_hv_perms'), 'w');
    User::redirectAfterLogin();
}

if (userquery::getInstance()->login_as_user($uid)) {
    if ($_COOKIE['pageredir']) {
        unset($_COOKIE['pageredir']);
    }
    User::redirectAfterLogin();
}
display_it();
