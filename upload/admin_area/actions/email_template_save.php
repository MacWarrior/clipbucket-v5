<?php
const THIS_PAGE = 'admin_email_template_save';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

if (empty($_POST['id_email_template'])) {
    $id_email_template = EmailTemplate::insertEmailTemplate($_POST);
    $success = (bool)$id_email_template;
} else {
    $success = EmailTemplate::updateEmailTemplate($_POST);
    $id_email_template = $_POST['id_email_template'];
}
$email_template = $_POST;
if ($success) {
    e(lang('success'),'m');
    $email_template = EmailTemplate::getOneTemplate(['id_email_template'=>$id_email_template]);
}

assign('template', $email_template);
assign('global_vars', EmailTemplate::getGlobalVariables());
$response = templateWithMsgJson('blocks/email_template_edit.html', false);
$response['success'] = $success;
$response['email_template_list'] = EmailTemplate::getAllTemplate([]);
echo json_encode($response);
