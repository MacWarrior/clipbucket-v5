<?php
const THIS_PAGE = 'update_info';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
if (!User::getInstance()->hasAdminAccess()) {
    return false;
}
if (!in_array($_POST['type'], ['core', 'db'])) {
    $type = '';
} else {
    $type = $_POST['type'];
}
Update::getInstance()->flush();
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367', true)) {
    $column = 'code';
    $core = 'update_core';
    $db = AdminTool::CODE_UPDATE_DATABASE_VERSION;
    $tools_wanted = [$db, $core];
    if ($type == 'db') {
        $tools_wanted = [$db];
    }
    $where = ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title IN(\'in_progress\',\'stopping\'))  AND code IN (\''.  implode("','", $tools_wanted) . '\')';
    $where_error = ' tools_histo.id_tools_histo_status IN (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title = \'on_error\')  AND code IN (\''.  implode("','", $tools_wanted) . '\')';
} else {
    $column = 'id_tool';
    $core = '11';
    $db = '5';
    $tools_wanted = [$db, $core];
    if ($type == 'db') {
        $tools_wanted = [$db];
    }
    $where = ' tools.id_tools_status IN (SELECT id_tools_status FROM ' . tbl('tools_status') . ' WHERE language_key_title IN(\'in_progress\',\'stopping\'))  AND id_tool IN ('.implode(',', $tools_wanted).')';
    $where_error = ' tools.id_tools_status IN (SELECT id_tools_status FROM ' . tbl('tools_status') . ' WHERE language_key_title = \'on_error\')  AND id_tool IN ('.implode(',', $tools_wanted).')';
}
try {
    $tools = AdminTool::getTools([$where]);
    $tools_error = [];
    $tools_error = AdminTool::getTools([$where_error]);
} catch (Exception $e) {
    exit();
}
$current_update = false;
$info_tool = false;
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

foreach ($tools_error as $tool) {
    $tool_error = new AdminTool();
    if ($column == 'code') {
        $tool_error->initByCode($tool['code']);
    } else {
        $tool_error->initById($tool['id_tool']);
    }
    if (System::isInDev()) {
        $logs = $tool_error->getLastLogs();
        foreach ($logs['logs'] as $log) {
            if (str_contains($log['message'], 'SQL : ')) {
                e($log['message']);
            }
        }
    } else {
        e(lang('technical_error'));
    }
}
//need to flush here to get last version
Update::getInstance()->flush();
//check if update is over and maintenance is enable
$last_tool = AdminTool::getLastestToolUpdate();
$is_maintenance_enabled = config('closed');
if (!$last_tool->isAlreadyLaunch()) {
    if ($last_tool->isToolInError() || Update::getInstance()->needCodeDBUpdate()) {
        $modal_error = lang('update_incomplete');
        if ($is_maintenance_enabled) {
            $modal_error .= '<br/><b>'.lang('maintenance_still_on').'</b>';
        }
    } elseif($is_maintenance_enabled) {
        myquery::getInstance()->Set_Website_Details('closed', 0);
        e(lang('update_completed_maintenance_off'), 'm');
    }
}
$msg_template = getTemplateMsg();
ob_start();
Update::getInstance()->displayGlobalSQLUpdateAlert($current_update);

echo json_encode(['html'         => ob_get_clean(),
                  'is_updating'  => (!empty($current_update) ? 'true' : 'false'),
                  'update_info'  => $info_tool,
                  'msg_template' => $msg_template,
                  'modal_error'  => $modal_error ?? 0
]);
