<?php
define('THIS_PAGE', 'admin_check_update');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$return = [];
if( config('enable_update_checker') == '1' ){
    Assign('update_checker_status', Update::getInstance()->getCoreUpdateStatus());
    assign('changelog_tab', [Update::getInstance()->getCurrentCoreVersionCode() => Update::getInstance()->getCurrentCoreVersion()]);
    $return = ['html'=>Update::getInstance()->getUpdateHTML(), 'changeLog'=>getTemplate('changelog.html')];
}
echo json_encode($return);