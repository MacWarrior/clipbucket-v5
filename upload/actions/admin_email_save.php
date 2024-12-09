<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

if (empty($_POST['id_email'])) {
    $success = EmailTemplate::insertEmail($_POST);
} else {
    $success = EmailTemplate::updateEmail($_POST);
}
if ($success) {
    e(lang('success'),'m');
}
echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg()
]);
