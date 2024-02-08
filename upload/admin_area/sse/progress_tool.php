<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no');
header('connection: keep-alive');
const THIS_PAGE = 'progress';
require_once dirname(__FILE__, 3) . '/includes/config.inc.php';

userquery::getInstance()->admin_login_check();

ignore_user_abort(false);
if (session_id()) {
    session_write_close();
}
if (ob_get_level() == 0) {
    ob_start();
}
while (true) {
    if (connection_aborted()) {
        exit();
    }

    try {
        $tools = AdminTool::getTools([
            ' elements_total IS NOT NULL '
        ]);
    } catch (Exception $e) {
        exit();
    }

    $sleep = 1;
    if (empty($tools)) {
        $sleep = 10;
    }

    $output = 'data: ';
    $returned_tools=[];
    foreach ($tools as $tool) {
        $returned_tools[] = [
            'id'             => $tool['id_tool'],
            'status'         => $tool['id_tools_status'],
            'status_title'   => lang($tool['language_key_title']),
            'pourcent'       => sprintf('%.2f', $tool['pourcentage_progress']),
            'elements_done'  => $tool['elements_done'],
            'elements_total' => $tool['elements_total']
        ];
    }
    $output .= json_encode($returned_tools);
    $output_beffering = ini_get('output_buffering') ?? 4096;
    $output .= str_pad('', $output_beffering) . "\n\n";
    echo $output;
    ob_flush();
    flush();
    sleep($sleep);
}