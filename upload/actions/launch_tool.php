<?php
define('THIS_PAGE', 'launch_tool');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');

$tool = new AdminTool();

/** if CLI , example : php launch_tool.php id_tool=7 */
if(php_sapi_name() === 'cli') {
    $param = CLI::getParams(); // get cli params

    /** check if required params are satisfied , else trow exception */
    CLI::checkRequiredParam('id_tool');

    $tool->initById((int) $param['id_tool']);

    if( ($param['automatic'] ?? '') == 'true' ) {

        if(config('automate_launch_mode') == 'disabled') {
            throw new Exception('config automate_launch_mode disabled');
        }

        if( $tool->isReadyForAutomaticLaunch() === false) {
            throw new Exception('id_tool '.((int) $param['id_tool']).' not ready for launch');
        }
    } else if($tool->isAlreadyLaunch()) {
        throw new Exception('id_tool '.((int) $param['id_tool']).' already launch');
    }

    $tool->setToolInProgress();
}
else {
    userquery::getInstance()->admin_login_check();
    $tool->initById($_POST['id_tool']);

    if($tool->isAlreadyLaunch()) {
        e(lang('tool_already_launched'));
        echo json_encode([
            'msg'              => getTemplateMsg()
            , 'libelle_status' => lang('on_error')
        ]);
        die();
    }

    sendClientResponseAndContinue(function () use ($tool) {
        $tool->setToolInProgress();
        echo json_encode([
            'msg'              => getTemplateMsg()
            , 'libelle_status' => lang('in_progress')
        ]);
    });
}

$tool->launch();
