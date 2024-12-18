<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

if (empty($_POST['id_email'])) {
    $id_email = EmailTemplate::insertEmail($_POST);
    $success = (bool)$id_email;
} else {
    $id_email = $_POST['id_email'];
    $success = EmailTemplate::updateEmail($_POST);
}
$email = $_POST;
if ($success) {
    e(lang('success'), 'm');
    $email = EmailTemplate::getOneEmail(['id_email' => $id_email]);
}
assign('email_templates', EmailTemplate::getAllTemplate([]));
assign('email', $email);
$response = templateWithMsgJson('blocks/email_edit.html', false);
$response['success'] = $success;
$response['email_list'] = EmailTemplate::getAllEmail([]);

echo json_encode($response);
