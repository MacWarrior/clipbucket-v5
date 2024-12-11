<?php
define('THIS_PAGE', 'admin_list_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$title_vars = EmailTemplate::getVariablesFromEmail($_POST['id_email'] ?: 0, 'title');
$content_vars = EmailTemplate::getVariablesFromEmail($_POST['id_email'] ?: 0, 'email');
assign('title_vars', $title_vars);
assign('content_vars', $content_vars);
echo templateWithMsgJson('blocks/email_edit_variable.html');
