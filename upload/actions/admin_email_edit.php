<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

//get template
assign('email_templates', EmailTemplate::getAllTemplate([]));
$email = EmailTemplate::getOneEmail(['id_email' => $_POST['id_email'] ?? 0]);
assign('email', $email);
assign('global_vars', EmailTemplate::getGlobalVariables());
assign('content_vars', EmailTemplate::getVariablesFromEmail($email['id_email']));
echo templateWithMsgJson('blocks/email_edit.html');
