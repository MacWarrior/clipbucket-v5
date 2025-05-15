<?php
const THIS_PAGE = 'update_info';
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'SSE.class.php';
if (!User::getInstance()->hasAdminAccess()) {
    return false;
}
SSE::processSSE(function () {
    Update::getInstance()->flush();
    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367', true)) {
        $column = 'code';
        $core = 'update_core';
        $db = AdminTool::CODE_UPDATE_DATABASE_VERSION;
        $where = ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM '.tbl('tools_histo_status').' WHERE language_key_title = \'in_progress\')  AND code IN (\'update_core\', \''.AdminTool::CODE_UPDATE_DATABASE_VERSION.'\')';
    } else {
        $column = 'id_tool';
        $core = '11';
        $db = '5';
        $where = ' tools.id_tools_status IN (SELECT id_tools_status FROM '.tbl('tools_status').' WHERE language_key_title = \'in_progress\')  AND id_tool IN (11, 5)';
    }
    try {
        $tools = AdminTool::getTools([$where]);
    } catch (Exception $e) {
        exit();
    }
    $current_update=false;
    $info_tool=false;
    foreach ($tools as $tool) {
        if ($tool[$column] == $core) {
            $current_update = 'core';
        } elseif (!$current_update && $tool[$column] == $db) {
            $current_update = 'db';
            $info_tool = [
                'id'             => $tool['id_tool'],
                'status'         => $tool['language_key_title'],
                'status_title'   => lang($tool['language_key_title']),
                'pourcent'       => sprintf('%.2f', $tool['pourcentage_progress']),
                'elements_done'  => $tool['elements_done'],
                'elements_total' => $tool['elements_total']
            ];
        }
    }
    //need to flush here to get last version
    Update::getInstance()->flush();
    ob_start();
    Update::getInstance()->displayGlobalSQLUpdateAlert($current_update);

    $output = 'data: ';
    $output .= json_encode(['html' => ob_get_clean(), 'is_updating'=>(!empty($current_update)? 'true':'false'), 'update_info'=>$info_tool]);
    return ['output'=>$output];
}, 5);
