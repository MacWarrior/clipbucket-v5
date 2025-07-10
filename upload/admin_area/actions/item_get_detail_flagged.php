<?php
define('THIS_PAGE', 'item_get_detail_flagged');
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (empty($_POST['type'])) {
    return false;
}
$type = $_POST['type'];
User::getInstance()->hasPermissionAjax(Flag::getPermissionByType($type));
if (empty($_POST['id_element'])) {
    sessionMessageHandler::add_message(lang('unknown'), 'e');
    return false;
}

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '255')) {
    sessionMessageHandler::add_message(lang('must_update_version'), 'e');
}

$page = mysql_clean($_POST['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$params = [
    'id_flag_type' => $_POST['id_flag_type'],
    'id_element'   => $_POST['id_element'],
    'element_type' => $_POST['type']
];
$params['limit'] = $get_limit;
$flagged = Flag::getAll($params);

if (empty($flagged)) {
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
pages::getInstance()->paginate($total_pages, $page, 'javascript:showDetail(' . $_POST['id_flag_type'] . ',' . $_POST['id_element'] . ', ' . $_POST['type'] . ',#page#);');

echo templateWithMsgJson('blocks/flagged_item_detail.html');
