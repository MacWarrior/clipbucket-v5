<?php
const THIS_PAGE = 'admin_launch_update';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$core_tool = new AdminTool();

$error_init = [];
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
    $error_init['core'] = $core_tool->initByCode('update_core');
    $error_init['db'] = AdminTool::getInstance()->initByCode('update_database_version');
} else {
    $error_init['core'] = $core_tool->initById(11);
    $error_init['db'] = AdminTool::getInstance()->initById(5);
}

if(($error_init['core'] === false && $_POST['type'] == 'core' )|| $error_init['db'] === false) {
    echo json_encode([
        'success' => false
        ,'error_msg' => System::isInDev() ? 'Failed to find tools for update' : lang('technical_error')
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

// TODO : Here, instead of continuing, we should start a new PHP process to avoid core modifications issue while already loaded by this current script
Update::getInstance()->flush();
if (($_POST['type'] == 'core' || $_POST['type'] == 'db') && AdminTool::getInstance()->isAlreadyLaunch() === false ) {
    AdminTool::getInstance()->setToolInProgress();
    AdminTool::getInstance()->launch();
}
