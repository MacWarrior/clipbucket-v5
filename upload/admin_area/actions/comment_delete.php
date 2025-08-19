<?php
const THIS_PAGE = 'comment_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$success = true;
if (empty($_POST['comment_id'])) {
    e(lang('missing_params'));
    $success = false;
} else {
    $success = (bool)Comments::delete(['comment_id' => $_POST['comment_id']]);
}
echo json_encode(['success'=>$success, 'msg'=>getTemplateMsg()]);
