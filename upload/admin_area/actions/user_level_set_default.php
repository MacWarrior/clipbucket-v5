<?php
const THIS_PAGE = 'admin_set_default_user_level';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$user_level_id = $_POST['user_level_id'];
$user_level = userquery::getInstance()->get_level_details($user_level_id);
if (empty($user_level)) {
    e(lang('user_level_not_found'));
    $success = false;
} else {
    $success = UserLevel::setDefault($user_level_id);
}
echo json_encode(['msg'=>getTemplateMsg(), 'success'=>$success]);
