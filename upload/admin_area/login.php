<?php
define('THIS_PAGE', 'admin_login');
require '../includes/admin_config.php';

if (userquery::getInstance()->is_admin_logged_as_user()) {
    userquery::getInstance()->revert_from_user();
    redirect_to('/admin_area');
}

if (User::getInstance()->hasAdminAccess()) {
    redirect_to(BASEURL . DirPath::getUrl('admin_area') . 'index.php');
}

if (isset($_POST['login'])) {
    $username = mysql_clean($_POST['username']);
    $password = mysql_clean($_POST['password']);

    //Logging User
    if (userquery::getInstance()->login_user($username, $password)) {
        redirect_to('index.php');
    }
}

if (user_id() && !User::getInstance()->hasAdminAccess()) {
    e(lang('you_dont_hv_perms'));
}

subtitle('Admin Login');
Template('global_header.html');
Template('login.html');
