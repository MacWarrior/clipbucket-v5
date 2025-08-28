<?php
const THIS_PAGE = 'admin_import_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$success = true;
if( Update::getInstance()->isWIPFile() ){
    try {
        execute_migration_file(DirPath::get('sql') . Update::getInstance()->getCurrentCoreVersion() . DIRECTORY_SEPARATOR . 'MWIP.php', false);
        CacheRedis::flushAll();
        Update::getInstance()->flush();
        Language::getInstance()->init();
    } catch (Exception $e) {
        $success = false;
    }

    if (errorhandler::getInstance()->get_error()) {
        $success = false;
    }
}

echo json_encode([
    'success'  => $success,
    'msg'      => getTemplateMsg(),
    'template' => template_wip_relaunch($success)
]);
