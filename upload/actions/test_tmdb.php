<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

try {
    $tmdb = new TMdb();
    $tmdb->init(new \Classes\Curl(TMdb::API_URL, $_REQUEST['token']));
    e(lang('success'),'m');
    $success = true;
} catch ( \Exception $e) {
    e($e->getMessage());
    $success = false;
}
echo json_encode(['success'=>$success, 'msg'=>getTemplateMsg()]);
