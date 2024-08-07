<?php
define('THIS_PAGE', 'activation');
define('PARENT_PAGE', 'signup');

require 'includes/config.inc.php';

if (userquery::getInstance()->udetails['usr_status'] == 'Ok') {
    redirect_to(BASEURL);
}

/**
 * Activating user account
 */
if (isset($_REQUEST['av_username']) || isset($_POST['activate_user'])) {
    $user = mysql_clean($_REQUEST['av_username']);
    $avcode = $_REQUEST['avcode'];
    userquery::getInstance()->activate_user_with_avcode($user, $avcode);
}

/**
 * Requesting Activation Code
 */
if (isset($_POST['request_avcode'])) {
    $email = mysql_clean($_POST['av_email']);
    userquery::getInstance()->send_activation_code($email);
}

template_files('activation.html');
display_it();
