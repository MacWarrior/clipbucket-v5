<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');
global $userquery;

$userquery->admin_login_check();
$tool = new AdminTool();
$tool->init($_POST['id_tool']);
$tool->stop();
echo json_encode([
    'msg'              => getTemplateMsg()
    , 'libelle_status' => lang('stopping')
]);
