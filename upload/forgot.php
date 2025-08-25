<?php
const THIS_PAGE = 'forgot';
require 'includes/config.inc.php';

if (config('disable_email') == 'yes') {
    redirect_to(DirPath::getUrl('root'));
}

if( User::getInstance()->isUserConnected() ){
    sessionMessageHandler::add_message(lang('you_already_logged'), 'e', DirPath::getUrl('root'));
}

$mode = $_GET['mode'];
assign('mode', $mode);
switch ($mode) {
    default:
        if (isset($_POST['reset'])) {
            $input = post('forgot_email');
            userquery::getInstance()->reset_password(1, $input);
        }
        break;

    case 'recover_username':
        if (isset($_POST['recover_username'])) {
            $email = mysql_clean($_POST['forgot_email']);
            userquery::getInstance()->recover_username($email);
        }
        break;

    case 'reset_pass':
        $user = get('user');
        if ($user) {
            $avcode = get('avcode');
            if (userquery::getInstance()->reset_password(2, $user, $avcode)) {
                assign('pass_recover', 'success');
            }
        }
        break;
}

subtitle(lang("com_forgot_username"));
template_files('forgot.html');
display_it();
