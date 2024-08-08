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
    echo json_encode([
        'success' => true
    ]);
});
if ($_POST['type'] == 'core' && $core_tool->isAlreadyLaunch() === false) {
    $core_tool->setToolInProgress();
    $core_tool->launch();
}
Update::getInstance()->flush();
if (($_POST['type'] == 'core' || $_POST['type'] == 'db') && $db_tool->isAlreadyLaunch() === false ) {
    $db_tool->setToolInProgress();
    $db_tool->launch();
}
