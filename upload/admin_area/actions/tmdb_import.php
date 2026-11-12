<?php
const THIS_PAGE = 'admin_import_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

try {
    $context = Tmdb::requestContext($_POST);
    Tmdb::getInstance()->importDataFromTmdb(
        $context['videoid'] ?? 0, $context['tmdb_video_id'] ?? 0, $_POST['type'] ?? '',
        $context['target'], $context['season'], $context['episode']
    );
} catch (Exception $exception) {
    e($exception->getMessage());
}

if (errorhandler::getInstance()->get_error()) {
    echo json_encode([
        'success' => false
        ,'msg'    => getTemplateMsg()
    ]);
} else {
    echo json_encode(['success' => true]);
}
