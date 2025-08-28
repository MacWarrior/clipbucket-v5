<?php
const THIS_PAGE = 'test_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

try {
    $tmdb = new TMdb();
    $tmdb->init(new \Classes\Curl(TMdb::API_URL, $_REQUEST['token']));
    $msg = 'OK';
    $success = true;
} catch ( \Exception $e) {
    $msg = 'KO';
    $success = false;
}
echo json_encode(['success'=>$success, 'msg'=>$msg]);
