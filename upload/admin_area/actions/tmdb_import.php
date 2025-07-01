<?php
define('THIS_PAGE', 'admin_import_tmdb');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
Tmdb::getInstance()->importDataFromTmdb($_POST['videoid'], $_POST['tmdb_video_id'], $_POST['type']);

if (errorhandler::getInstance()->get_error() ) {
    echo json_encode([
        'success' => false
        , 'msg'   => getTemplateMsg()
    ]);
} else {
    echo json_encode(['success' => true]);
}
