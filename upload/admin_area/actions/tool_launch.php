<?php
define('THIS_PAGE', 'launch_tool');
if (php_sapi_name() === 'cli') {
    $in_bg_cron = true;
}
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'admin_tool.class.php';

$tool = new AdminTool();

/** if CLI , example : php tool_launch.php id_tool=7 */
if (php_sapi_name() === 'cli') {
    if( !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '99') ){
        return;
    }

    $param = CLI::getParams(); // get cli params

    /** check if required params are satisfied , else trow exception */
    CLI::checkRequiredParam('id_tool');

    if ($tool->initById((int)$param['id_tool']) === false) {
        echo 'id_tool ' . $param['id_tool'] . ' not exists';
        die();
    }

    if (($param['automatic'] ?? '') == 'true') {

        if (config('automate_launch_mode') == 'disabled' || empty(config('automate_launch_mode'))) {
            echo 'config automate_launch_mode disabled';
            die();
        }

        if ($tool->isReadyForAutomaticLaunch() === false) {
            echo 'id_tool ' . ((int)$param['id_tool']) . ' not ready for launch';
            die();
        }

    } elseif($tool->isAlreadyLaunch()) {
        echo'id_tool '.((int) $param['id_tool']).' already launch';
        die();
    }

    $tool->setToolInProgress();
} else {
    User::getInstance()->hasPermissionAjax('admin_access');

    if($tool->initById($_POST['id_tool']) === false) {
        e(lang('tool_not_found'));
        echo json_encode([
            'msg'              => getTemplateMsg()
            , 'libelle_status' => lang('on_error')
        ]);
        die();
    }

    if ($tool->isAlreadyLaunch()) {
        e(lang('tool_already_launched'));
        echo json_encode([
            'msg'            => getTemplateMsg()
            , 'libelle_status' => lang('on_error')
        ]);
        die();
    }

    sendClientResponseAndContinue(function () use ($tool) {
        $tool->setToolInProgress();
        echo json_encode([
            'msg'            => getTemplateMsg()
            , 'libelle_status' => lang('in_progress')
        ]);
    });
}

$tool->launch();
