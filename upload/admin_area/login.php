<?php
const THIS_PAGE = 'admin_login';
require '../includes/admin_config.php';

if (User::getInstance()->hasAdminAccess()) {
    redirect_to(DirPath::getUrl('admin_area') . 'index.php');
}

if (isset($_POST['login'])) {
    $username = mysql_clean($_POST['username']);
    $password = mysql_clean($_POST['password']);

    //Logging User
    if (userquery::getInstance()->login_user($username, $password)) {
        redirect_to(DirPath::getUrl('admin_area') . 'index.php');
    }
}

if (user_id() && !User::getInstance()->hasAdminAccess()) {
    e(lang('you_dont_hv_perms'));
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(
    ['pages/login/login' . $min_suffixe . '.js' => 'admin']
);

subtitle('Admin Login');
Template('global_header.html');
Template('login.html');
