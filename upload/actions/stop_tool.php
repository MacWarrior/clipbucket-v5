<?php
define('THIS_PAGE', 'stop_tool');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');

User::getInstance()->hasPermissionAjax('admin_access');
$tool = new AdminTool();
$tool->initById($_POST['id_tool']);
$tool->stop();
echo json_encode([
    'msg'              => getTemplateMsg()
    , 'libelle_status' => lang('stopping')
]);
