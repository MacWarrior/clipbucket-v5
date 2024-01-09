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
$x = true;
while ($x) {
    try {
        $tools = AdminTool::getTools([
            ' elements_total IS NOT NULL '
        ]);
    } catch (Exception $e) {
    }
    if (empty($tools)) {
        $x = false;
    }
    foreach ($tools as $tool) {
        $output = 'data: ' . json_encode([
                'id'       => $tool['id_tool'],
                'pourcent' => $tool['pourcentage_progress']
            ]);
        $output .= str_pad('', 4096) . "\n\n";
        echo $output;
        ob_flush();
        flush();
    }
    if (connection_aborted()) {
        exit();
    }
    sleep(1);
}