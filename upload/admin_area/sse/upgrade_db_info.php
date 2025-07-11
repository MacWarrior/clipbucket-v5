<?php
const THIS_PAGE = 'upgrade_db_info';
const IS_SSE = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'SSE.class.php';
if (!User::getInstance()->hasAdminAccess()) {
    return false;
}
SSE::processSSE(function () {
    $path_file_temp = dirname(__FILE__, 3) . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'process_migration';
    $info = false;
    try {
        $info = file_get_contents($path_file_temp);
        if ($info) {
            $info = json_decode($info, true);
            $info['pourcent'] = sprintf('%.2f', ($info['elements_done'] * 100 / $info['elements_total']));
        }
    } catch (Exception $e) {
        exit();
    }

    $sleep = 1;

    $output = 'data: ';
    $output .= json_encode($info);
    return [
        'output' => $output,
        'sleep'  => $sleep
    ];
}, 3);
