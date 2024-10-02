<?php
define('THIS_PAGE', 'membership_user_levels');
global $pages, $Upload, $eh, $myquery, $cbvid, $breadcrumb;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('memberships'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('subscribers'),
    'url'   => DirPath::getUrl('admin_area') . 'users_memberships.php'
];


$page = mysql_clean($_GET['page']);
$params = [
    'order' => $_POST['sort'] ? $_POST['sort'] . ' ' . $_POST['sort_order'] : 'first_start DESC',
];
assign('sort', $_POST['sort']);
assign('sort_order', $_POST['sort_order']);
$params['limit'] = create_query_limit($page, config('admin_pages'));
$params['group'] = Membership::getInstance()->getTablenameUserMembership() . '.userid';
$params['get_subscribers'] = true;
if (!empty($_POST['username'])) {
    $params['username'] = $_POST['username'];
    assign('username', $_POST['username']);
}
if (!empty($_POST['user_level_id'])) {
    $params['user_level_id'] = $_POST['user_level_id'];
    assign('user_level_id', (int)$_POST['user_level_id']);
}

$users_memberships = Membership::getInstance()->getAllSubscribers($params);
assign('users_memberships', $users_memberships);
assign('user_levels', userquery::getInstance()->get_levels() ?: []);
if (empty($users_memberships)) {
    $total_rows = 0;
} else {
    if (count($users_memberships) < config('admin_pages') && ($page == 1 || empty($page))) {
        $total_rows = count($users_memberships);
    } else {
        $params['count'] = true;
        unset($params['limit']);
        unset($params['order']);
        $total_rows = Membership::getInstance()->getAll($params);
    }
}
$total_pages = count_pages($total_rows, config('admin_pages'));
$pages->paginate($total_pages, $page);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'pages/membership/users_memberships' . $min_suffixe . '.js' => 'admin',
]);

subtitle(lang('subscribers'));
template_files('users_memberships.html');
display_it();
