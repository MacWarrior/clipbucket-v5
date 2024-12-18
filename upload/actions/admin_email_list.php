<?php
define('THIS_PAGE', 'admin_list_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$params = [];
if (!empty($_POST['search'])) {
    $params['code']=$_POST['search'];
}
EmailTemplate::assignListEmailTemplate('email',$params);

echo templateWithMsgJson('blocks/email_list.html');
