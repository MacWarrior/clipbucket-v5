<?php
define('THIS_PAGE', 'admin_email_template_delete');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

$success = EmailTemplate::deleteTemplate($_POST['id_email_template'] ?? 0);
echo json_encode([
    'success'             => $success,
    'msg'                 => getTemplateMsg(),
    'email_template_list' => EmailTemplate::getAllTemplate([])
]);
