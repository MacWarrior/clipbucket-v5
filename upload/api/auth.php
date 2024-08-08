<?php
include('../includes/config.inc.php');
include('global.php');

$request = $_REQUEST;
$mode = strtolower($request['mode']);

$api_keys = ClipBucket::getInstance()->api_keys;

if ($api_keys) {
    if (!in_array($request['api_key'], $api_keys)) {
        exit(json_encode(['err' => 'App authentication error']));
    }
}

switch ($mode) {
    case "login":
        $uDetails = ['username', 'userid', 'email', 'total_videos', 'total_photos', 'total_collections'];

        $userDetails = [];
        foreach ($uDetails as $ud) {
            $userDetails[$ud] = userquery::getInstance()->udetails[$ud];
        }

        $userDetails['sess_id'] = $_COOKIE['PHPSESSID'];
        $username = $request['username'];
        $password = $request['password'];

        if (userquery::getInstance()->userid) {
            $userDetails['avatar'] = $video['user_photo'] = $video['displayPic'] = userquery::getInstance()->getUserThumb($userDetails);
            exit(json_encode(['status' => 'ok', 'userid' => userquery::getInstance()->userid, 'details' => $userDetails]));
        }

        function onLoginMobile()
        {
            $uDetails = ['username', 'userid', 'email', 'total_videos', 'total_photos', 'total_collections'];
            $userDetails = [];
            foreach ($uDetails as $ud) {
                $userDetails[$ud] = userquery::getInstance()->udetails[$ud];
            }

            $userDetails['sess_id'] = $_COOKIE['PHPSESSID'];
            $userDetails['avatar'] = $video['user_photo'] = $video['displayPic'] = userquery::getInstance()->getUserThumb($userDetails);
            exit(json_encode(['status' => 'ok', 'userid' => userquery::getInstance()->userid, 'type' => 'custom', 'details' => $userDetails]));
        }

        $onLogin = 'onLoginMobile';

        if (cb_get_functions('signup_page')) {
            cb_call_functions('signup_page');
        }

        userquery::getInstance()->login_user($username, $password);

        if (error()) {
            exit(json_encode(['status' => 'failed', 'msg' => error('single')]));
        } else {
            $uDetails = ['username', 'userid', 'email', 'total_videos', 'total_photos', 'total_collections'];
            $userDetails = [];
            foreach ($uDetails as $ud) {
                $userDetails[$ud] = userquery::getInstance()->udetails[$ud];
            }
            $userDetails['sess_id'] = $_COOKIE['PHPSESSID'];
            $userDetails['avatar'] = $video['user_photo'] = $video['displayPic'] = userquery::getInstance()->getUserThumb($userDetails);
            exit(json_encode(['status' => 'ok', 'userid' => userquery::getInstance()->userid, 'sess_id' => $_COOKIE['PHPSESSID'], 'details' => $userDetails]));
        }
        break;

    case "getuser":
    case "check_auth":
    case "is_logged_in":
    case "checkauth":
    case "isloggedin":
        $userid = user_id();
        if (!user_id()) {
            exit(json_encode(['status' => 'failed', 'msg' => 'User is not logged in', 'session' => $_COOKIE['PHPSESSID']]));
        } else {
            $uDetails = ['username', 'userid', 'email', 'total_videos', 'total_photos', 'total_collections'];

            $userDetails = [];
            foreach ($uDetails as $ud) {
                $userDetails[$ud] = userquery::getInstance()->udetails[$ud];
            }

            $userDetails['sess_id'] = $_COOKIE['PHPSESSID'];
            $userDetails['avatar'] = $video['user_photo'] = $video['displayPic'] = userquery::getInstance()->getUserThumb($userDetails);
            exit(json_encode($userDetails));
        }
        break;

    case "logout":
        userquery::getInstance()->logout();
        if (cb_get_functions('logout')) {
            cb_call_functions('logout');
        }
        set_cookie_secure('is_logout', 'yes');
        break;
}
