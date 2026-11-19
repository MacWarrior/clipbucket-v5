<?php
const THIS_PAGE = 'forgot';
require 'includes/config.inc.php';

if (config('disable_email') == 'yes') {
    redirect_to(DirPath::getUrl('root'));
}

if (User::getInstance()->isUserConnected()) {
    sessionMessageHandler::add_message(lang('you_already_logged'), 'e', DirPath::getUrl('root'));
}
if ((empty(trim(config('base_url'))) || !filter_var(config('base_url'), FILTER_VALIDATE_URL))) {
    sessionMessageHandler::add_message(lang('cant_perform_action_until_app_fully_updated'), 'e', User::getInstance()->getDefaultHomepageFromUserLevel());
}

$mode = $_GET['mode'];
assign('mode', $mode);
switch ($mode) {
    default:
        if (isset($_POST['reset'])) {
            $input = post('email');
            if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '136')) {
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
        $input = !empty($_POST) ? $_POST : $_GET;
        $email = is_string($input['email'] ?? null) ? $input['email'] : '';
        $avcode = is_string($input['avcode'] ?? null) ? $input['avcode'] : '';
        assign('email', $email);
        assign('avcode', $avcode);
        assign('pass_change', false);

        $user = $email !== '' && $avcode !== '' ? User::getInstance()->getOne(['email_strict' => $email]) : false;
        if (empty($user) || !User::isPasswordResetTokenValid($user, $avcode)) {
            if (!empty($_POST) || isset($_GET['email']) || isset($_GET['avcode'])) {
                e(lang('recap_verify_failed'));
            }
            break;
        }

        assign('pass_change', true);
        if (!empty($_POST['change_password'])) {
            if (empty($_POST['password']) || empty($_POST['cpassword'])
                || !is_string($_POST['password']) || !is_string($_POST['cpassword'])) {
                e(lang('usr_pass_err2'));
            } elseif ($_POST['password'] !== $_POST['cpassword']) {
                e(lang('usr_cpass_err1'));
            } elseif (User::changePasswordWithResetToken($user, $avcode, $_POST['password'])) {
                sessionMessageHandler::add_message(lang('usr_pass_email_msg'), 'm', DirPath::getUrl('root') . 'signup.php?mode=login');
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
