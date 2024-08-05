<?php
define('THIS_PAGE', 'show_tool_log');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
$tool = new AdminTool();
$tool->initById($_POST['id_tool']);

$info_logs = $tool->getLastLogs();
assign('tool_log_list', $info_logs['logs']);
$return = templateWithMsgJson('blocks/tool_log_list.html', false);
$return ['id_tool'] = $_POST['id_tool'];
$return ['max_id_log'] = !empty($info_logs['max_id_log']) ? $info_logs['max_id_log'] : 0 ;
echo json_encode($return);
