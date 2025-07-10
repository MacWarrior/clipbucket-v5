<?php
define('THIS_PAGE', 'admin_check_update');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$return = [];
if( config('enable_update_checker') == '1' ){
    Assign('update_checker_status', Update::getInstance()->getCoreUpdateStatus());
    assign('changelog_tab', [Update::getInstance()->getCurrentCoreVersionCode() => Update::getInstance()->getCurrentCoreVersion()]);
    $return = ['html'=>Update::getInstance()->getUpdateHTML(), 'changeLog'=>getTemplate('changelog.html'), 'version'=>Update::getInstance()->getCurrentCoreVersion(), 'revision'=>Update::getInstance()->getCurrentCoreRevision()];
}
//get logs
$last_tool = AdminTool::getLastestToolUpdate();
$logs = $last_tool->getLastLogs();

foreach ($logs['logs'] as $log) {
    if ($log['message'] != lang('tool_started') && $log['message'] != lang('tool_ended')) {
        e($log['message'], 'w');
        $return['msg']= getTemplateMsg();
    }
}
echo json_encode($return);