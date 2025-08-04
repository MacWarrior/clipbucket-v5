<?php
if( !defined('THIS_PAGE') ){
    define('THIS_PAGE', 'login');
    require 'includes/config.inc.php';
    redirect_to(cblink(['name' => 'error_403']));
}

$need_mfa = false;
if (empty($_POST['username']) || empty($_POST['password'])) {
    e(lang('missing_params'));
    $success = false;
} else {
    $username = mysql_clean($_POST['username']);
    $password = mysql_clean($_POST['password']);
    $remember_me = mysql_clean($_POST['remember_me'] ?? false);
//check MFA
    $code_mfa_ok = true;
     if (config('enable_multi_factor_authentification') != 'disabled' && userquery::getInstance()->authenticate($username, $password)) {
        if (empty($_POST['mfa_code'])) {
            $need_mfa = User::checkAndSendMFAmail($username);
            $code_mfa_ok = !$need_mfa;
        } else {
            $user = User::getInstance()->getOne(['username' => $username]);
            if (time() - strtotime($user['mfa_date']) > 900) {
                $success = false;
                $code_mfa_ok = false;
                e(lang('mfa_code_expired'));
                //reset MFA code
                Clipbucket_db::getInstance()->update(tbl('users'), ['mfa_code', 'mfa_date'], ['null','null'], 'username = \''.$username.'\'');
            } elseif ($user['mfa_code'] != $_POST['mfa_code']) {
                $success = false;
                $code_mfa_ok = false;
                e(lang('invalid_mfa_code'));
            }
        }
    }
//Logging User
    if ($code_mfa_ok && userquery::getInstance()->login_user($username, $password, $remember_me)) {
        if (empty($redirect)) {
            $redirect = User::getInstance()->getDefaultHomepageFromUserLevel();
        }
        $header = './';
        //if not complete URL
        if (!preg_match('/https?:\/\//', $redirect)) {
            //make sure we don't have .// in URL
            $url = preg_replace('/\/\//', '/', $header . $redirect);
        }
        $success = true;

    } else {
        $success = false;
    }
}

echo json_encode([
    'success'  => $success,
    'need_mfa' => $need_mfa,
    'msg'      => getTemplateMsg(),
    'redirect' => $redirect ?? '',
]);
