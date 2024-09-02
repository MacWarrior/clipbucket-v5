<?php
define('THIS_PAGE', 'admin_comment_delete');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$success = true;
if (empty($_POST['comment_id'])) {
    e(lang('missing_params'));
    $success = false;
} else {
    $success = (bool)Comments::delete(['comment_id' => $_POST['comment_id']]);
}
echo json_encode(['success'=>$success, 'msg'=>getTemplateMsg()]);
