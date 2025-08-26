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
            $input = post('email');
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
        if (!empty($_REQUEST['email']) && !empty($_REQUEST['avcode']) && empty($_POST['userid'])) {
            $user = User::getInstance()->getOne(['email' => $_REQUEST['email']]);
            if (empty($user)) {
                e(lang('user_not_exist'));
            } else {
                $code = $_REQUEST['avcode'];
                if ($user['avcode'] != $code) {
                    e(lang('recap_verify_failed'));
                }
                assign('userid', $user['userid'] ?? 0);
                assign('pass_change', true);
                //display pass field
            }
        } else {
            if (!empty($_POST['userid'])) {
                assign('pass_change', true);
                $user = User::getInstance()->getOne(['userid' => $_POST['userid']]);
                assign('userid', $user['userid'] ?? 0);
                if (!empty($user)) {
                    if (empty($_POST['password']) || empty($_POST['cpassword'])) {
                        e(lang('usr_pass_err2'));
                    } elseif ($_POST['password'] != $_POST['cpassword']) {
                        e(lang('usr_cpass_err1'));
                    } else {
                        Clipbucket_db::getInstance()->update(tbl('users'), ['password', 'avcode'], [pass_code($_POST['password'], $user['userid']), ''], ' userid=\'' . $user['userid'] . '\'');
                        Session::kill_all_sessions($user['userid']);
                        sessionMessageHandler::add_message(lang('usr_pass_email_msg'), 'm', DirPath::getUrl('root').'signup.php?mode=login');
                    }
                }
            }
        }
        break;
}

subtitle(lang("com_forgot_username"));
template_files('forgot.html');
display_it();
