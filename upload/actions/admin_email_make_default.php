<?php
define('THIS_PAGE', 'admin_email_make_default');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

EmailTemplate::makeDefault($_POST['make_default'], $_POST['default_all']);
EmailTemplate::assignListEmailTemplate('email_template');

echo templateWithMsgJson('blocks/email_template_list.html');
