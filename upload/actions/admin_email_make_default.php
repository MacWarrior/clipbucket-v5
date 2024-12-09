<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

EmailTemplate::makeDefault($_POST['make_default']);
EmailTemplate::assignListEmailTemplate();

echo templateWithMsgJson('blocks/email_template_list.html');
