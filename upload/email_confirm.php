<?php
const THIS_PAGE = 'email_confirm';
const PARENT_PAGE = 'signup';

require 'includes/config.inc.php';

if( userquery::getInstance()->udetails['usr_status'] == 'Ok' ){
    redirect_to(DirPath::getUrl('root'));
}

/**
 * Activating user account
 */
if (isset($_REQUEST['av_username']) || isset($_POST['activate_user'])) {
    $user = mysql_clean($_REQUEST['av_username']);
    $avcode = $_REQUEST['avcode'];
    userquery::getInstance()->activate_user_with_avcode($user, $avcode, true);
}


template_files('activation.html');
display_it();
