<?php
define('THIS_PAGE', 'admin_import_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

Tmdb::getInstance()->importDataFromTmdb($_POST['videoid'], $_POST['tmdb_video_id']);

if (errorhandler::getInstance()->get_error() ) {
    echo json_encode([
        'success' => false
        , 'msg'   => getTemplateMsg()
    ]);
} else {
    echo json_encode(['success' => true]);
}
