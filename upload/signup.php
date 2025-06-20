<?php
define('THIS_PAGE', 'signup');
define('PARENT_PAGE', 'signup');
require 'includes/config.inc.php';

if (User::getInstance()->isUserConnected()) {
    redirect_to(DirPath::getUrl('root'));
}

/**
 * Function used to call all signup functions
 */
if (cb_get_functions('signup_page')) {
    cb_call_functions('signup_page');
}

/**
 * Signing up new user
 */
if (!config('allow_registeration')) {
    assign('allow_registeration', lang('usr_reg_err'));
}

if (isset($_POST['signup'])) {
    if (!config('allow_registeration')) {
        e(lang('usr_reg_err'));
    } else {
        $form_data = $_POST;
        $signup_data = $form_data;
        $signup_data['password'] = mysql_clean($signup_data['password']);
        $signup_data['cpassword'] = mysql_clean($signup_data['cpassword']);
        $signup_data['email'] = mysql_clean($signup_data['email']);
        $signup_data['level'] = UserLevel::getDefaultId();
        $signup = userquery::getInstance()->signup_user($signup_data);

        // checking if user signup was successful
        if ($signup) {
            // user signed up, lets get his details
            $udetails = userquery::getInstance()->get_user_details($signup);
            errorhandler::getInstance()->flush();
            assign('udetails', $udetails);
            if (empty(ClipBucket::getInstance()->configs['email_verification'])) {
                // login user and redirect to home page
                userquery::getInstance()->login_as_user($udetails['userid']);
                header('Location: ' . DirPath::getUrl('root'));
            } else {
                assign('mode', 'signup_success');
            }
        }
    }
}

//Login User
if (isset($_POST['login'])) {
    $username = mysql_clean($_POST['username']);
    $password = mysql_clean($_POST['password']);

    $remember = false;
    if ($_POST['remember_me']) {
        $remember = true;
    }

    if (userquery::getInstance()->login_user($username, $password, $remember)) {
       User::redirectAfterLogin();
    }
}

//Checking Ban Error
if (!isset($_POST['login']) && !isset($_POST['signup'])) {
    if (@$_GET['ban'] == true) {
        $msg = lang('usr_ban_err');
    }
}

if($_GET['mode'] ?? '' == 'login'){
    subtitle(lang('login'));
    template_files('pages/login.html');
} else {
    subtitle(lang('signup'));
    $datepicker_js_lang = '';
    if( Language::getInstance()->getLang() != 'en'){
        $datepicker_js_lang = '_languages/datepicker-'.Language::getInstance()->getLang();
    }

    $min_suffixe = System::isInDev() ? '' : '.min';
    ClipBucket::getInstance()->addJS([
        'jquery_plugs/datepicker'.$datepicker_js_lang.'.js' => 'global',
        'pages/signup/signup' . $min_suffixe . '.js'        => 'admin'
    ]);
    template_files('signup.html');
}

display_it();
