<?php
define('THIS_PAGE', 'admin_launch_update');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
$core_tool = new AdminTool();
$db_tool = new AdminTool();
if (Update::IsCurrentDBVersionIsHigherOrEqualTo(AdminTool::MIN_VERSION_CODE, AdminTool::MIN_REVISION_CODE)) {
    $core_tool->initByCode('update_core');
    $db_tool->initByCode('update_database_version');
} else {
    $core_tool->initById(11);
    $db_tool->initById(5);
}

sendClientResponseAndContinue(function () use ($core_tool) {
    $core_tool->setToolInProgress();
    echo json_encode([
       'success' => true
    ]);
});
$core_tool->launch();
$db_tool->setToolInProgress();
$db_tool->launch();
