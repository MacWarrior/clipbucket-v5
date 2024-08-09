<?php
define('THIS_PAGE', 'admin_launch_update');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
$core_tool = new AdminTool();
$db_tool = new AdminTool();
$error_init = [];
if (Update::IsCurrentDBVersionIsHigherOrEqualTo(AdminTool::MIN_VERSION_CODE, AdminTool::MIN_REVISION_CODE)) {
    $error_init['core'] = $core_tool->initByCode('update_core');
    $error_init['db'] = $db_tool->initByCode('update_database_version');
} else {
    $error_init['core'] = $core_tool->initById(11);
    $error_init['db'] = $db_tool->initById(5);
}

if($error_init['core'] === false || $error_init['db'] === false) {
    echo json_encode([
        'success' => false
        ,'error_msg' => in_dev() ? 'Failed to find tools for update' : lang('technical_error')
    ]);
    die();
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
