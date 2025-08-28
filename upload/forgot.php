<?php
const THIS_PAGE = 'forgot';
require 'includes/config.inc.php';

if (config('disable_email') == 'yes') {
    redirect_to(DirPath::getUrl('root'));
}

if (User::getInstance()->isUserConnected()) {
    sessionMessageHandler::add_message(lang('you_already_logged'), 'e', DirPath::getUrl('root'));
}

$mode = $_GET['mode'];
assign('mode', $mode);
switch ($mode) {
    default:
        if (isset($_POST['reset'])) {
            $input = post('email');
            if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
                e(lang('technical_error'));
            } else {
                userquery::getInstance()->reset_password($input);
            }
        }
        break;

    case 'recover_username':
        if (isset($_POST['recover_username'])) {
            $email = mysql_clean($_POST['forgot_email']);
            userquery::getInstance()->recover_username($email);
        }
        break;

    case 'reset_pass':
        if (!empty($_REQUEST['email']) && !empty($_REQUEST['avcode'])) {
            $user = User::getInstance()->getOne(['email_strict' => $_REQUEST['email']]);
            if (empty($user)) {
                e(lang('recap_verify_failed'));
            } else {
                $success = true;

                $code = $_REQUEST['avcode'];
                if (empty($user['avcode']) || $user['avcode'] != $code) {
                    e(lang('recap_verify_failed'));
                    $success = false;
                } else {
                    assign('avcode', $user['avcode']);
                    assign('email', $user['email']);
                }
                assign('pass_change', $success);
                //display pass field
            }
        } else {
            $user = User::getInstance()->getOne(['email_strict' => $_POST['email']]);
            assign('avcode', $user['avcode'] ?? '');
            assign('email', $user['email'] ?? '');
            if (!empty($user) && $user['avcode'] == ($_POST['avcode'] ?? null) && !empty($user['avcode'])) {
                assign('pass_change', true);
                if (!empty($_POST['change_password'])) {
                    if (empty($_POST['password']) || empty($_POST['cpassword'])) {
                        e(lang('usr_pass_err2'));
                    } elseif ($_POST['password'] != $_POST['cpassword']) {
                        e(lang('usr_cpass_err1'));
                    } else {
                        Clipbucket_db::getInstance()->update(tbl('users'), ['password', 'avcode'], [pass_code($_POST['password'], $user['userid']), ''], ' userid=\'' . $user['userid'] . '\'');
                        Session::kill_all_sessions($user['userid']);
                        sessionMessageHandler::add_message(lang('usr_pass_email_msg'), 'm', DirPath::getUrl('root') . 'signup.php?mode=login');
                    }
                }
            } else {
                e(lang('recap_verify_failed'));
                assign('pass_change', false);
            }
        }
        break;
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'pages/forgot/forgot' . $min_suffixe . '.js' => 'admin'
]);

subtitle(lang("com_forgot_username"));
template_files('forgot.html');
display_it();
