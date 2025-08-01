<?php
const THIS_PAGE = 'admin_activate_user_level';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$user_level_id = $_POST['user_level_id'];
$user_level = userquery::getInstance()->get_level_details($user_level_id);
if (empty($user_level)) {
    e(lang('user_level_not_found'));
    $success = false;
} else {
    $success =  User::getInstance()->toggleUserLevelActivation($user_level_id, $_POST['active'] == 'true');
}
echo json_encode(['msg'=>getTemplateMsg(), 'success'=>$success]);
