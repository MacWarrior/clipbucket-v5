<?php
define('THIS_PAGE', 'launch_tool');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');

$tool = new AdminTool();

/** si nous sommes en cli , exemple : php launch_tool.php id_tool=7 */
if(php_sapi_name() === 'cli') {
    $param = CLI::getParams(); // recuperation des params

    /** check if required params are satisfied , else trow exception */
    CLI::checkRequiredParam('id_tool');

    $tool->initById((int) $param['id_tool']);

    if( $param['automatic'] == 'true' ) {
        if( $tool->isReadyForAutomaticLaunch() === false) {
            throw new Exception('id_tool '.((int) $param['id_tool']).' not ready for launch');
        }
    } else if($tool->isAlreadyLaunch()) {
        throw new Exception('id_tool '.((int) $param['id_tool']).' already launch');
    }

    $tool->setToolInProgress();
}
/** si nous sommes en http on passe en SSE */
else {
    userquery::getInstance()->admin_login_check();
    $tool->initById($_POST['id_tool']);

    /** @todo check si deja lancé et gestion de l'echec */
    if($tool->isAlreadyLaunch()) {
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
