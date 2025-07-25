<?php
const THIS_PAGE = 'update_frequency_tool';
const IS_AJAX = true;

require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once(DirPath::get('classes') . 'admin_tool.class.php');
require_once DirPath::get('classes') . 'cron_expression.class.php';

$json = [];

try {
    $tool = new AdminTool();
    User::getInstance()->hasPermissionAjax('admin_access');
    if ($tool->initById($_POST['id_tool']) === false) {
        throw new Exception('tool not found');
    }

    try {
        $tool->updateFrequency($_POST['frequency']);
        $json['success'] = true;
        $json['msg'] = lang('success_update_tools');
    } catch (\Throwable $exception) {
        $json['error'] = lang('bad_format_cron') . '.<br/>' . lang('cron_format_title');
        $json['success'] = false;
    }

} catch (\Throwable $e) {
    $json['success'] = false;
    $json['error'] = lang('error_occured');
}

echo json_encode($json);
