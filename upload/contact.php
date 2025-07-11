<?php
const THIS_PAGE = 'contact';

require 'includes/config.inc.php';

$name = post('name');
$email = post('email');
$reason = post('reason');
$message = post('message');

if (isset($_POST['contact'])) {
    if (empty($name)) {
        e(lang('name_was_empty'));
    } elseif (empty($email) || !isValidEmail($email)) {
        e(lang('invalid_email'));
    } elseif (empty($reason)) {
        e(lang('pelase_enter_reason'));
    } elseif (empty($message)) {
        e(lang('please_enter_something_for_message'));
    } elseif (!verify_captcha()) {
        e(lang('recap_verify_failed'));
    } else {
        $var = [
            'sender_username' => substr($name, 0, 100),
            'sender_email'    => substr($email, 0, 100),
            'subject'         => substr($reason, 0, 300),
            'sender_message'  => $message
        ];

        //Now Finally Sending Email
        if (EmailTemplate::sendMail('contact_form', config('email_sender_address'), $var, $email, $name)) {
            e(lang('email_send_confirm'), 'm');
        }
    }
}

subtitle(lang('contact_us'));

template_files('contact.html');
display_it();
