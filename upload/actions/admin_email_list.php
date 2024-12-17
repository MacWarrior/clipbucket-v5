<?php
define('THIS_PAGE', 'admin_list_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

EmailTemplate::assignListEmailTemplate('email');

echo templateWithMsgJson('blocks/email_list.html');
