<?php
define('THIS_PAGE', 'online_users');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'View online users', 'url' => DirPath::getUrl('admin_area') . 'online_users.php'];

if ($_GET['kick']) {
    if (Session::getInstance()->kick(mysql_clean($_GET['kick']))) {
        e("User has been kicked out", "m");
    }
}

//Getting User List
$result_array['limit'] = $get_limit;
if (!$array['order']) {
    $result_array['order'] = ' doj DESC ';
}

$users = get_users($result_array);

Assign('users', $users);

$online_users = userquery::getInstance()->get_online_users(false);
assign('total', count($online_users));
assign('online_users', $online_users);
assign('queryString', queryString(null, 'kick'));
subtitle("View online users");
template_files('online_users.html');
display_it();
