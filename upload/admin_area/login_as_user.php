<?php
const THIS_PAGE = 'login_as_user';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
User::getInstance()->hasPermissionOrRedirect('member_moderation',true);

$uid = (int)$_GET['uid'];

if (!UserLevel::canLogAsUser(User::getInstance()->getCurrentUserID(), $uid)) {
    SessionMessageHandler::add_message(lang('you_dont_hv_perms'),'e', User::redirectAfterLoginOrError('url'));
}

if (userquery::getInstance()->login_as_user($uid)) {
    redirect_to(User::getInstance()->getDefaultHomepageFromUserLevel());
}
display_it();
