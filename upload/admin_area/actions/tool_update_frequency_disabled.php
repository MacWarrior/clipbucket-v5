<?php
define('THIS_PAGE', 'update_frequency_disabled_tool');

require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once(DirPath::get('classes') . 'admin_tool.class.php');

$json = [];

try {
    $tool = new AdminTool();
    User::getInstance()->hasPermissionAjax('admin_access');
    if ($tool->initById($_POST['id_tool']) === false) {
        throw new Exception('tool not found');
    }
    $tool->updateIsDisabled(($_POST['is_disabled'] == 'true'));
    $json['success'] = true;
    $json['msg'] = lang('success_update_tools');
} catch (\Throwable $e) {
    $json['success'] = false;
    $json['error'] = lang('error_occured');
}

echo json_encode($json);
