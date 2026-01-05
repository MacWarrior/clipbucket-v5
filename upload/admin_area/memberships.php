<?php
define('THIS_PAGE', 'membership_user_levels');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('admin_access');
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('memberships'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('user_levels'),
    'url'   => DirPath::getUrl('admin_area') . 'memberships.php'
];


$page = mysql_clean($_GET['page']);
$params['limit'] = create_query_limit($page, config('admin_pages'));
$params['group'] = Membership::getInstance()->getTablename() .'.id_membership';
$params['get_nb_users'] = true;
$memberships = Membership::getInstance()->getAll($params);
assign('memberships', $memberships);
if (empty($memberships)) {
    $total_rows = 0;
} else {
    if (count($memberships) < config('admin_pages') && ($page == 1 || empty($page))) {
        $total_rows = count($memberships);
    } else {
        $params['count'] = true;
        unset($params['limit']);
        unset($params['order']);
        unset($params['get_nb_users']);
        $total_rows = Membership::getInstance()->getAll($params);
    }
}
$total_pages = count_pages($total_rows, config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'pages/membership/memberships' . $min_suffixe . '.js' => 'admin',
]);

subtitle(lang('user_levels'));
template_files('memberships.html');
display_it();
