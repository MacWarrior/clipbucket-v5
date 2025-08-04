<?php
const THIS_PAGE = 'email_confirm';
const PARENT_PAGE = 'signup';

require 'includes/config.inc.php';

if (config('disable_email') == 'yes') {
    redirect_to(DirPath::getUrl('root'));
}

$mode = $_GET['mode'] ?? 'activation';
switch ($mode) {
    case 'activation':
        if( User::getInstance()->isUserConnected() ){
            redirect_to(DirPath::getUrl('root'));
        }

        if( isset($_POST['av_username']) && isset($_POST['avcode']) ){
            User::confirmAccount($_POST['av_username'], $_POST['avcode']);
        }

        template_files('pages/user_activation.html');
        break;

    case 'email_confirm':
        if( isset($_REQUEST['avcode']) ){
            if( User::getInstance()->isUserConnected() ){
                if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999') && empty(User::getInstance()->get('email_temp')) && User::getInstance()->get('email_confirmed') == 1 ){
                    sessionMessageHandler::add_message(lang('email_already_confirmed'), 'm', DirPath::getUrl('root'));
                }
                $user = User::getInstance()->get('username');
            } else {
                $user = $_POST['av_username'];
            }

            $avcode = $_REQUEST['avcode'];
            if( User::confirmEmail($user, $avcode) ){
                sessionMessageHandler::add_message(lang('email_confirmed'), 'm', DirPath::getUrl('root'));
            }
        }
        template_files('pages/email_confirmation.html');
        break;

    case 'request':
        if( User::getInstance()->isUserConnected() ){
            redirect_to(DirPath::getUrl('root'));
        }
        if( isset($_POST['av_email']) ){
            if( !isvalidEmail( $_POST['av_email'] ) ){
                e(lang('usr_email_err2'));
            } else {
                userquery::getInstance()->send_activation_code($_POST['av_email']);
            }
        }
        template_files('pages/request_activation_code.html');
        break;
}


display_it();
