<?php
define('THIS_PAGE', 'update_check_before_launch');
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$response['core_checked'] = $_POST['core_checked'] ??false;
$response['db_checked'] = $_POST['db_checked'] ??false;
$response['conversion_checked'] = $_POST['conversion_checked'] ??false;
$response['confirm_message'] = '';

if (!$response['core_checked'])  {
    $core_tool = new AdminTool();
    $core_tool->initByCode('update_core');
    if ($core_tool->isAlreadyLaunch()) {
        $response['id_tool'] = $core_tool->getId();
        $response['confirm_message_core'] = lang('alert_update_core_already_ongoing');
        echo json_encode($response);
        die;
    } else {
        $response['core_checked'] = true;
    }
}
if (!$response['db_checked'])  {
    $db_tool = new AdminTool();
    $db_tool->initByCode('update_database_version');
    if ($db_tool->isAlreadyLaunch()) {
        $response['id_tool'] = $db_tool->getId();
        $response['confirm_message_db'] = lang('alert_update_db_already_ongoing');
        echo json_encode($response);
        die;
    } else {
        $response['db_checked'] = true;
    }
}
if (!$response['conversion_checked'])  {
    /** @var AdminTool $core_tool */
    if (!empty(myquery::getInstance()->get_conversion_queue(' time_completed is null or time_completed = \'\' or time_completed = 0'))) {
        $response['confirm_message_conv'] = lang('alert_video_conversion_ongoing');
        echo json_encode($response);
        die;
    } else {
        $response['conversion_checked'] = true;
    }
}
echo json_encode($response);
