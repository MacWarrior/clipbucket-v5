<?php
define('THIS_PAGE', 'update_phrase');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$id_membership = $_POST['id_membership'];
$membership = Membership::getInstance()->getOne(['id_membership'=>$id_membership, 'get_user_membership'=>true]);
if (!empty($membership['id_user_membership'])) {
    e(lang('cant_delete_membership_at_least_one_user'));
    $success = false;
} else {
    $success =  Membership::getInstance()->delete($id_membership);
}
if ($success) {
    e(lang('membership_deleted'), 'm');
}
$url='';
if (!empty($_POST['redirect'])) {
    SessionMessageHandler::add_message(lang('membership_deleted'));
    $url = DirPath::getUrl('admin_area') .'memberships.php';
}
echo json_encode(['msg'=>getTemplateMsg(), 'success'=>$success, 'url'=>$url]);
