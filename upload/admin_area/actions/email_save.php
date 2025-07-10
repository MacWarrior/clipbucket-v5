<?php
define('THIS_PAGE', 'admin_email_save');
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

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
assign('global_vars', EmailTemplate::getGlobalVariables());
assign('content_vars', EmailTemplate::getVariablesFromEmail(!empty($email['id_email']) ? $email['id_email'] : 0));
$response = templateWithMsgJson('blocks/email_edit.html', false);
$response['success'] = $success;
$response['email_list'] = EmailTemplate::getAllEmail([]);

echo json_encode($response);
