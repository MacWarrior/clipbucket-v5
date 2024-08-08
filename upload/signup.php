<?php
define('THIS_PAGE', 'signup');
define('PARENT_PAGE', 'signup');

require 'includes/config.inc.php';
global $eh;
if (userquery::getInstance()->login_check('', true)) {
    redirect_to(BASEURL);
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
        $signup = userquery::getInstance()->signup_user($signup_data);

        // checking if user signup was successful
        if ($signup) {
            // user signed up, lets get his details
            $udetails = userquery::getInstance()->get_user_details($signup);
            $eh->flush();
            assign('udetails', $udetails);
            if (empty(ClipBucket::getInstance()->configs['email_verification'])) {
                // login user and redirect to home page
                userquery::getInstance()->login_as_user($udetails['userid']);
                header('Location: ' . BASEURL);
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
    if ($_POST['rememberme']) {
        $remember = true;
    }

    if (userquery::getInstance()->login_user($username, $password, $remember)) {
        if ($_COOKIE['pageredir']) {
            redirect_to($_COOKIE['pageredir']);
        } else {
            redirect_to(cblink(['name' => 'my_account']));
        }
    }
}

//Checking Ban Error
if (!isset($_POST['login']) && !isset($_POST['signup'])) {
    if (@$_GET['ban'] == true) {
        $msg = lang('usr_ban_err');
    }
}

$datepicker_js_lang = '';
if( Language::getInstance()->getLang() != 'en'){
    $datepicker_js_lang = '_languages/datepicker-'.Language::getInstance()->getLang();
}
ClipBucket::getInstance()->addJS(['jquery_plugs/datepicker'.$datepicker_js_lang.'.js' => 'global']);

subtitle(lang('signup'));
//Displaying The Template
template_files('signup.html');
display_it();
