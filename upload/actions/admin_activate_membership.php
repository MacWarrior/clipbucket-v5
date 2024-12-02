<?php
define('THIS_PAGE', 'update_phrase');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$id_membership = $_POST['id_membership'];
$membership = Membership::getInstance()->getOne(['id_membership'=>$id_membership]);
if (empty($membership)) {
    e(lang('cant_delete_membership_at_least_one_user'));
    $success = false;
} else {
    $success =  Membership::getInstance()->update(['id_membership'=>$id_membership, 'disabled'=>$_POST['disabled']]);
}
echo json_encode(['msg'=>getTemplateMsg(), 'success'=>$success]);
