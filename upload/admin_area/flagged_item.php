<?php
define('THIS_PAGE', 'flagged_item');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$right = 'admin_access';
if (empty($_GET['type'])) {
    redirect_to('/');
}
$type = $_GET['type'] ;
$right = Flag::getPermissionByType($type);
User::getInstance()->hasPermissionOrRedirect($right,true);

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', 999)) {
    sessionMessageHandler::add_message(lang('must_update_version'), 'e', get_server_url(). DirPath::getUrl('admin_area'));
}

global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang($type . 's'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang($type . '_flagged'),
    'url'   => DirPath::getUrl('admin_area') . 'flagged_item.php?type=' . $type
];

// Creating Limit
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$params['limit'] = $get_limit;
$params['element_type'] = $type;
$params['group_by_type'] = true;
$flagged = Flag::getAll($params);

if( empty($flagged) ){
    $total_rows = 0;
} else {
    $params['count'] = true;
    unset($params['limit']);
    unset($params['order']);
    $total_rows = Flag::getAll($params);
}
assign('flagged', $flagged);
assign('type', $type);
$total_pages = count_pages($total_rows, config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/flagged_item/flagged_item'.$min_suffixe.'.js' => 'admin']);

switch ($type) {
    case 'video':
        $link_fo_function = 'video_link';
}
template_files('flagged_item.html');
display_it();