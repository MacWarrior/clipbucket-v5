<?php
define('THIS_PAGE', "contact");

require 'includes/config.inc.php';

$name = post('name');
$email = post('email');
$reason = post('reason');
$message = post('message');

if (isset($_POST['contact'])) {
    if (empty($name)) {
        e(lang("name_was_empty"));
    } elseif (empty($email) || !is_valid_syntax('email', $email)) {
        e(lang("invalid_email"));
    } elseif (empty($reason)) {
        e(lang("pelase_enter_reason"));
    } elseif (empty($message)) {
        e(lang("please_enter_something_for_message"));
    } elseif (!verify_captcha()) {
        e(lang('recap_verify_failed'));
    } else {
        $tpl = $cbemail->get_template('contact_form');
        $var = [
            '{name}'       => substr($name, 0, 100),
            '{email}'      => substr($email, 0, 100),
            '{reason}'     => substr($reason, 0, 300),
            '{message}'    => $message,
            '{ip_address}' => Network::get_remote_ip(),
            '{now}'        => now()
        ];

        $subj = $cbemail->replace($tpl['email_template_subject'], $var);
        $msg = nl2br($cbemail->replace($tpl['email_template'], $var));

        //Now Finally Sending Email
        if (cbmail(['to' => SUPPORT_EMAIL, 'from' => $email, 'subject' => $subj, 'content' => $msg])) {
            e(lang("email_send_confirm"), "m");
        }
    }
}

subtitle(lang("contact_us"));

template_files('contact.html');
display_it();
