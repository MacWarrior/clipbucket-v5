<?php
define('THIS_PAGE', 'test_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

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
