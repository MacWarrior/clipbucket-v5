<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$success = EmailTemplate::deleteTemplate($_POST['id_email_template'] ?? 0);
echo json_encode(['success'=>$success, 'msg'=>getTemplateMsg()]);
