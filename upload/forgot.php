<?php
define('THIS_PAGE', "forgot");
define('PARENT_PAGE', 'signup');

require 'includes/config.inc.php';

$mode = $_GET['mode'];

if (config('disable_email') == 'yes') {
    redirect_to(config('baseurl'));
}

/**
 * Reseting Password
 * Sending Email
 */
if (isset($_POST['reset'])) {
    $input = post('forgot_username');
    userquery::getInstance()->reset_password(1, $input);
}

/**
 * Reseting Password
 * Real Reseting ;)
 */
$user = mysql_clean(get('user'));
if ($mode == 'reset_pass' && $user) {
    $input = mysql_clean(get('user'));
    $avcode = mysql_clean(get('avcode'));
    if (userquery::getInstance()->reset_password(2, $input, $avcode)) {
        assign('pass_recover', 'success');
    }
}

/**
 * Recovering username
 */
if (isset($_POST['recover_username'])) {
    $email = mysql_clean($_POST['forgot_email']);
    $msg = userquery::getInstance()->recover_username($email);
}

assign('mode', $mode);

subtitle(lang("com_forgot_username"));
template_files('forgot.html');
display_it();
