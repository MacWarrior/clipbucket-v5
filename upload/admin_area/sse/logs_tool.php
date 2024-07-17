<?php
const THIS_PAGE = 'logs';
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'SSE.class.php';
userquery::getInstance()->admin_login_check();
$max_id = $_GET['max_id'];
SSE::processSSE(function () use(&$max_id){
    $tool = new AdminTool();
    $tool->initById($_GET['id_tool']);

    $info_logs = $tool->getLastLogs($max_id);
    $max_id = $info_logs['max_id_log'];
    $output = 'data: ' . json_encode($info_logs['logs']);
    return['output'=> $output];
}, 1);