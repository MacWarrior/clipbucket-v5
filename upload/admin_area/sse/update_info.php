<?php
const THIS_PAGE = 'update_info';
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'SSE.class.php';
userquery::getInstance()->admin_login_check();

SSE::processSSE(function () {
    if (Update::IsCurrentDBVersionIsHigherOrEqualTo(AdminTool::MIN_VERSION_CODE, AdminTool::MIN_REVISION_CODE)) {
        $column = 'code';
        $core = 'update_core';
        $db = AdminTool::CODE_UPDATE_DATABASE_VERSION;
        $and = ' AND code IN (\'update_core\', \''.AdminTool::CODE_UPDATE_DATABASE_VERSION.'\')';
    } else {
        $column = 'id_tool';
        $core = '11';
        $db = '5';
        $and = ' AND id_tool IN (11, 5)';
    }
    try {
        $tools = AdminTool::getTools([
            ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM '.tbl('tools_histo_status').' WHERE language_key_title = \'in_progress\') ' . $and
        ]);
    } catch (Exception $e) {
        exit();
    }
    $current_update=false;
    foreach ($tools as $tool) {
        if ($tool[$column] == $core) {
            $current_update = 'core';
        } elseif (!$current_update && $tool[$column] == $db) {
            $current_update = 'db';
        }
    }
    //need to flush here to get last version
    Update::getInstance()->flush();
    ob_start();
    Update::getInstance()->displayGlobalSQLUpdateAlert($current_update);

    $output = 'data: ';
    $output .= json_encode(['html' => ob_get_clean(), 'is_updating'=>(!empty($current_update)? 'true':'false')]);
    return ['output'=>$output];
}, 5);
