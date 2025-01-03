<?php
define('THIS_PAGE', 'admin_email_template_edit');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

//get template
$template = EmailTemplate::getOneTemplate(['id_email_template' => $_POST['id_email_template'] ?? 0]);
assign('template', $template);
assign('global_vars', EmailTemplate::getGlobalVariables());
echo templateWithMsgJson('blocks/email_template_edit.html');
