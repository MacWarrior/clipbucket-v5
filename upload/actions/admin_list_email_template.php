<?php
define('THIS_PAGE', 'admin_list_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

//get template
$template = [];
assign('template', $template);
echo templateWithMsgJson('blocks/email_template_edit.html');