<?php
define('THIS_PAGE', 'admin_edit_email_template');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$success = true;
if (empty($_POST['id_email'])) {
    e(lang('unknown_email'));
    $success = false;
} else {
    $email = EmailTemplate::getOneEmail(['id_email' => $_POST['id_email']]);
}
if (empty($_POST['email_recipient'])) {
    e(lang('missing_email_recipient'));
    $success = false;
} else {
    $_POST['email_recipient'] = filter_var($_POST['email_recipient'], FILTER_SANITIZE_EMAIL);
    if (filter_var($_POST['email_recipient'], FILTER_VALIDATE_EMAIL) === false) {
        $success = false;
        e(lang('invalid_email_recipient'));
//        throw new \Exception('Please provide a valid recipient email address');
    }
}
if (empty($_POST['recipient'])) {
    e(lang('missing_recipient'));
    $success = false;
}
if (empty($_POST['email_sender'])) {
    if (!empty(config('email_sender_address'))) {
        $_POST['email_sender'] = config('email_sender_address');
    } else {
        e(lang('missing_email_sender'));
        $success = false;
    }
} else {
    $_POST['email_sender'] = filter_var($_POST['email_sender'], FILTER_SANITIZE_EMAIL);
    if (filter_var($_POST['email_sender'], FILTER_VALIDATE_EMAIL) === false) {
        $success = false;
        e(lang('invalid_email_sender'));
//        throw new \Exception('Please provide a valid sender email address');
    }
}
if (empty($_POST['sender'])) {
    if (!empty(config('email_sender_name'))) {
        $_POST['sender'] = config('email_sender_name');
    } else {
        e(lang('missing_sender'));
        $success = false;
    }
}
if ($success) {
    //sendMail
    $success = EmailTemplate::sendMail($email['code'], [
        'mail' => $_POST['email_recipient'],
        'name' => $_POST['recipient']
    ], array_merge(
            ($_POST['variables']['title'] ?? [])
            , ($_POST['variables']['email'] ?? [])
        )
        , $_POST['email_sender']
        , $_POST['sender']
        , true);
}
if ($success) {
    e(lang('success'), 'm');
}
echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg()
]);
