<?php
const THIS_PAGE = 'action_logs';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('action_logs'), 'url' => DirPath::getUrl('admin_area') . 'action_logs.php'];
$limit = 20;

//Getting User List
if (isset($_GET['clean'])) {
    Clipbucket_db::getInstance()->execute('TRUNCATE TABLE ' . tbl('action_log'));
}

if (isset($_GET['type']) && in_array($_GET['type'], CBLogs::$allowed_types, true)) {
    $type = $_GET['type'];
    $result_array['type'] = $type;
}
assign('type', $type??false);
$page = (int)$_GET['page'];
$get_limit = create_query_limit($page, $limit);
$result_array['limit'] = $get_limit;
$logs = fetch_action_logs($result_array);
$result_array['count'] = true;
$total_rows = fetch_action_logs($result_array);
assign('total_logs', count($logs));
assign('logs', $logs);
subtitle(lang('action_logs'));
$total_pages = count_pages($total_rows, $limit);
pages::getInstance()->paginate($total_pages, $page);
template_files('action_logs.html');
display_it();
