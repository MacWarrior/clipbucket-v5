<?php
define('THIS_PAGE', 'admin_import_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$success = true;
if( Update::getInstance()->isWIPFile() ){
    try {
        execute_migration_file(DirPath::get('sql') . Update::getInstance()->getCurrentDBVersion() . DIRECTORY_SEPARATOR . 'MWIP.php', false);
    } catch (Exception $e) {
        $success = false;
    }

    if (errorhandler::getInstance()->get_error()) {
        $success = false;
    }
}

echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg()
]);
