<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

//get template
$success = EmailTemplate::insertEmailTemplate($_POST);
if ($success) {
    e(lang(),'m');
}
echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg()
]);