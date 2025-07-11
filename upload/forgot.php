<?php
const THIS_PAGE = 'forgot';

require 'includes/config.inc.php';

$mode = $_GET['mode'];

if (config('disable_email') == 'yes') {
    redirect_to(DirPath::getUrl('root'));
}

if( User::getInstance()->isUserConnected() ){
    sessionMessageHandler::add_message(lang('you_already_logged'), 'e', DirPath::getUrl('root'));
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
$user = get('user');
if ($mode == 'reset_pass' && $user) {
    $avcode = get('avcode');
    if (userquery::getInstance()->reset_password(2, $user, $avcode)) {
        assign('pass_recover', 'success');
    }
}

/**
 * Recovering username
 */
if (isset($_POST['recover_username'])) {
    $email = mysql_clean($_POST['forgot_email']);
    userquery::getInstance()->recover_username($email);
}

assign('mode', $mode);

subtitle(lang("com_forgot_username"));
template_files('forgot.html');
display_it();
