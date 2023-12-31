<?php
global $userquery,$pages;
require_once '../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'View online users', 'url' => DirPath::getUrl('admin_area') . 'online_users.php'];

if ($_GET['kick']) {
    if ($sess->kick(mysql_clean($_GET['kick']))) {
        e("User has been kicked out", "m");
    }
}

//Getting User List
$result_array['limit'] = $get_limit;
if (!$array['order']) {
    $result_array['order'] = " doj DESC ";
}

$users = get_users($result_array);

Assign('users', $users);

$online_users = $userquery->get_online_users(false);
assign('total', count($online_users));
assign('online_users', $online_users);
assign('queryString', queryString(null, 'kick'));
subtitle("View online users");
template_files('online_users.html');
display_it();
