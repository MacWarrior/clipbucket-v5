<?php
const THIS_PAGE = 'admin_login';
require '../includes/admin_config.php';

if (User::getInstance()->hasAdminAccess()) {
    redirect_to(DirPath::getUrl('admin_area') . 'index.php');
}

if (user_id() && !User::getInstance()->hasAdminAccess()) {
    e(lang('you_dont_hv_perms'));
}

subtitle('Admin Login');
Template('global_header.html');
Template('login.html');
