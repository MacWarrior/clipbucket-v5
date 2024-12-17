<?php
define('THIS_PAGE', 'admin_list_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$email = EmailTemplate::getOneEmail(['id_email' => ($_POST['id_email'] ?: 0)]);
$title_vars = EmailTemplate::getVariablesFromEmail($email, 'title');
$content_vars = EmailTemplate::getVariablesFromEmail($email, 'email');
assign('title_vars', $title_vars);
assign('content_vars', $content_vars);
echo templateWithMsgJson('blocks/email_edit_variable.html');
