<?php
const THIS_PAGE = 'admin_email_edit';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

//get template
assign('email_templates', EmailTemplate::getAllTemplate([]));
$email = EmailTemplate::getOneEmail(['id_email' => $_POST['id_email'] ?? 0]);
assign('email', $email);
assign('global_vars', EmailTemplate::getGlobalVariables());
assign('content_vars', EmailTemplate::getVariablesFromEmail(!empty($email['id_email']) ? $email['id_email'] : 0));
echo templateWithMsgJson('blocks/email_edit.html');
