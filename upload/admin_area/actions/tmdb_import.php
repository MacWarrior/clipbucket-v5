<?php
const THIS_PAGE = 'admin_import_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

Tmdb::getInstance()->importDataFromTmdb($_POST['videoid'] ?? 0, $_POST['tmdb_video_id'] ?? 0, $_POST['type']);

if (errorhandler::getInstance()->get_error()) {
    echo json_encode([
        'success' => false
        ,'msg'    => getTemplateMsg()
    ]);
} else {
    echo json_encode(['success' => true]);
}
