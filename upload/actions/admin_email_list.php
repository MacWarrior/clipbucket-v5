<?php
define('THIS_PAGE', 'admin_email_list');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

$params = [];
if (!empty($_POST['search'])) {
    $params['code']=$_POST['search'];
}
EmailTemplate::assignListEmailTemplate('email',$params);

echo templateWithMsgJson('blocks/email_list.html');
