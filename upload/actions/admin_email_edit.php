<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

//get template
assign('email_templates', EmailTemplate::getAllTemplate([]));
assign('email', EmailTemplate::getOneEmail(['id_email' => $_POST['id_email'] ?? 0]));
echo templateWithMsgJson('blocks/email_edit.html');
