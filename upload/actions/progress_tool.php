<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no');
header('connection: keep-alive');
const THIS_PAGE = 'progress';
include("../includes/config.inc.php");
ignore_user_abort(false);
if (session_id()) {
    session_write_close();
}
if (ob_get_level() == 0) {
    ob_start();
}
while (true) {
    try {
        $tools = AdminTool::getTools([
            ' elements_total IS NOT NULL '
        ]);
    } catch (Exception $e) {
    }
    if (empty($tools)) {
        $sleep = 10;
    }
    $sleep = 5;
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
    $output .= str_pad('', 4096) . "\n\n";
    echo $output;
    ob_flush();
    flush();
    if (connection_aborted()) {
        exit();
    }
    sleep($sleep);
}