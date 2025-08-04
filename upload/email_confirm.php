<?php
const THIS_PAGE = 'email_confirm';
const PARENT_PAGE = 'signup';

require 'includes/config.inc.php';

if (isset($_REQUEST['av_username']) || isset($_POST['activate_user'])) {
    $user = mysql_clean($_REQUEST['av_username']);
    $avcode = $_REQUEST['avcode'];
    if (User::confirmEmail( $user, $avcode)) {
        sessionMessageHandler::add_message(lang('email_confirmed'), 'm', DirPath::getUrl('root'));
    }
}


template_files('activation.html');
display_it();
