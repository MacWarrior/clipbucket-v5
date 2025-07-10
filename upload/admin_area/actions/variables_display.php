<?php
define('THIS_PAGE', 'variables_display');
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

$email = EmailTemplate::getOneEmail(['id_email' => ($_POST['id_email'] ?: 0)]);
assign('global_vars', EmailTemplate::getGlobalVariables(true));
assign('content_vars', EmailTemplate::getVariablesFromEmail($email['id_email']));
echo templateWithMsgJson('blocks/email_edit_variable.html');
