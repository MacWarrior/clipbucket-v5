<?php
const THIS_PAGE = 'stop_tool';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'admin_tool.class.php';

$tool = new AdminTool();
$tool->initById($_POST['id_tool']);
$tool->stop();
echo json_encode([
    'msg'              => getTemplateMsg()
    , 'libelle_status' => lang('stopping')
]);
