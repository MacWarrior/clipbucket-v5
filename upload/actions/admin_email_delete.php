<?php
define('THIS_PAGE', 'admin_email_delete');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

$success = EmailTemplate::deleteEmail($_POST['id_email'] ?? 0);
echo json_encode([
    'success'    => $success,
    'msg'        => getTemplateMsg(),
    'email_list' => EmailTemplate::getAllEmail([])
]);
