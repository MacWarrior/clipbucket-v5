<?php
const THIS_PAGE = 'statistics_online';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

assign('ongoing_conversion', VideoConversionQueue::getAll(['count' => true, 'not_complete'=>true]));
assign('online_users', count(userquery::getInstance()->get_online_users()));
$progress_tools = [];
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
    $progress_tools = AdminTool::getTools([
        '  tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title IN(\'in_progress\',\'stopping\'))'
    ]);
}
if (!in_array($_POST['active'], ['li_ongoing_tools', 'li_live_statistics']) || empty($progress_tools)) {
    $active = 'li_live_statistics';
} else {
    $active = $_POST['active'];
}
assign('active_statistic_pane', $active);
assign('progress_tools', $progress_tools);

echo json_encode([
    'html' => getTemplate('blocks/statistics_online.html')
]);
