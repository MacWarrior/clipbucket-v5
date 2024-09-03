<?php
define('THIS_PAGE', 'action_logs');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Action Logs', 'url' => DirPath::getUrl('admin_area') . 'action_logs.php?type=login'];

//Getting User List
if (isset($_GET['clean'])) {
    Clipbucket_db::getInstance()->execute('TRUNCATE TABLE ' . tbl('action_log'));
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $result_array['type'] = $type;
}
if (isset($_GET['limit'])) {
    $result_array['limit'] = $_GET['limit'];
} else {
    $result_array['limit'] = 20;
}
if (!$array['order']) {
    $result_array['order'] = " DESC ";
}

$logs = fetch_action_logs($result_array);
assign('total_logs', count($logs));
assign('logs', $logs);
subtitle("Action Logs");
template_files('action_logs.html');
display_it();
