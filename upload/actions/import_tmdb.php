<?php
define('THIS_PAGE', 'import_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (config('tmdb_enable_on_front_end') != 'yes' || config('enable_tmdb') != 'yes' || config('tmdb_token') == '') {
    return false;
}

Tmdb::getInstance()->importDataFromTmdb($_POST['videoid'], $_POST['tmdb_video_id']);

if (errorhandler::getInstance()->get_error()) {
    echo json_encode([
        'success' => false,
        'msg'     => getTemplateMsg()
    ]);
} else {
    echo json_encode([
        'success'      => true,
        'video_detail' => Video::getInstance()->getOne([
            'videoid' => $_POST['videoid']
        ])
    ]);
}
