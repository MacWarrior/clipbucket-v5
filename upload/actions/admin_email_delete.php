<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$success = EmailTemplate::deleteEmail($_POST['id_email'] ?? 0);
echo json_encode(['success'=>$success, 'msg'=>getTemplateMsg()]);
