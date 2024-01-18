<?php
define('THIS_PAGE', 'ADMIN_LOGIN');
require '../includes/admin_config.php';
Assign('THIS_PAGE', 'login');

if ($userquery->is_admin_logged_as_user()) {
    $userquery->revert_from_user();
    redirect_to('/admin_area');
}

if ($userquery->admin_login_check(true)) {
    redirect_to(BASEURL . DirPath::getUrl('admin_area') . 'index.php');
}

$thisurl = $_SERVER['PHP_SELF'];
Assign('THIS_URL', $thisurl);

if (!empty($_REQUEST['returnto'])) {
    $return_to = $_REQUEST['returnto'];
    Assign('return_to', $return_to);
}

if (isset($_POST['login'])) {
    $username = mysql_clean($_POST['username']);
    $password = mysql_clean($_POST['password']);

    //Logging User
    if ($userquery->login_user($username, $password)) {
        redirect_to('index.php');
    }
}

if (user_id() && !has_access('admin_access', true)) {
    e(lang("you_dont_hv_perms"));
}

subtitle('Admin Login');
Template('global_header.html');
Template('login.html');
