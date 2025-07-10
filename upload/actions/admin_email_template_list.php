<?php
define('THIS_PAGE', 'admin_email_template_list');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

EmailTemplate::assignListEmailTemplate('email_template');

echo templateWithMsgJson('blocks/email_template_list.html');
