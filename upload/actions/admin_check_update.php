<?php
define('THIS_PAGE', 'admin_check_update');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$return = [];
if( config('enable_update_checker') == '1' ){
    assign('changelog_tab', [Update::getInstance()->getCurrentCoreVersionCode() => Update::getInstance()->getCurrentCoreVersion()]);
    $return = ['status'=> Update::getInstance()->getCoreUpdateStatus(), 'html'=>Update::getInstance()->getUpdateHTML(), 'changeLog'=>getTemplate('changelog.html')];
}
echo json_encode($return);