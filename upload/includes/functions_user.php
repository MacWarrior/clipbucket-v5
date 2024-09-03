<?php
function get_user_fields($array = null)
{
    global $cb_columns;
    return $cb_columns->object('users')->get_columns();
}

/**
 * Get name of a user from array
 *
 * @param { array } { $user_array } { array with user details }
 * @return mixed|string { string } { $name } { name of user fetched from array }
 */
function name($user_array)
{
    $user = $user_array;
    $name = '';
    if (isset($user['first_name']) && $user['first_name']) {
        $name = $user['first_name'];
    }
    if (isset($user['last_name']) && $user['last_name']) {
        $name .= " " . $user['last_name'];
    }
    if (isset($user['anonym_name']) && $user['anonym_name']) {
        $name = $user['anonym_name'];
    }
    if (!$name) {
        $name = $user['username'];
    }
    return $name;
}

function profile_fileds_check($array): bool
{
    $post_clean = true;
    if (preg_match('/[0-9]+/', $array['first_name']) || preg_match('/[0-9]+/', $array['last_name'])) {
        e('Name contains numbers! Seriously? Are you alien?');
        $post_clean = false;
    }

    if (!empty($array['web_url'])) {
        if (!filter_var($array['web_url'], FILTER_VALIDATE_URL)) {
            e('Invalid URL provided.');
            $post_clean = false;
        }
    }

    if (!is_numeric($array['postal_code']) && !empty($array['postal_code'])) {
        e("Don't fake it! Postal Code can't be words!");
        $post_clean = false;
    }

    if( !empty($array['dob']) && config('enable_user_dob_edition') != 'yes'){
        e(lang('user_dob_edition_disabled'));
        $post_clean = false;
    }

    return $post_clean;
}

/**
 * Resend verification email to a given user
 * @param: { integer } { $userid } { id of user to resend verification to }
 * @return false|mixed : { boolean } { true if success, else false }
 * @throws Exception
 * @author: Saqib Razzaq
 * @since: March 10th, 2016 ClipBucket 2.8.1
 */
function resend_verification($userid)
{
    $raw_data = Clipbucket_db::getInstance()->select(tbl("users"), "usr_status,username,email", "userid = '$userid'");
    $usr_status = $raw_data[0]['usr_status'];
    $uname = $raw_data[0]['username'];
    $email = $raw_data[0]['email'];
    if (trim($usr_status) == "ToActivate") {
        global $cbemail;
        $avcode = RandomString(10);
        Clipbucket_db::getInstance()->update(tbl("users"), ["avcode"], [$avcode], "userid = '$userid'");
        $tpl = $cbemail->get_template('email_verify_template');
        $more_var = ['{username}' => $uname,
                     '{email}'    => $email,
                     '{avcode}'   => $avcode,
        ];
        if (!is_array($var)) {
            $var = [];
        }
        $var = array_merge($more_var, $var);
        $subj = $cbemail->replace($tpl['email_template_subject'], $var);
        $msg = nl2br($cbemail->replace($tpl['email_template'], $var));
        //Now Finally Sending Email
        cbmail(['to' => $email, 'from' => WEBSITE_EMAIL, 'subject' => $subj, 'content' => $msg]);
        return $uname;
    }

    return false;
}

/**
 * Returns playable video for user's channel page
 * @param : { array } { $userVideos } { an array user videos }
 * @return : { string / boolean } { video key if found a video matches pattern else false }
 * @since : November 17th, 2016 ClipBucket 2.8.2
 * @author : Saqib Razzaq
 */

function userMainVideo($userVideos)
{
    if (is_array($userVideos)) {
        $userid = userquery::getInstance()->userid;
        foreach ($userVideos as $key => $video) {
            $vBroadcast = trim($video['broadcast']);
            $vKey = $video['videokey'];
            switch ($vBroadcast) {
                case 'private':
                    if (is_numeric($userid)) {
                        $allowedUsers = explode(',', $video['video_users']);
                        if (in_array($userid, $allowedUsers)) {
                            return $vKey;
                        }
                    }
                    break;
                case 'logged':
                    if (is_numeric($userid)) {
                        return $vKey;
                    }
                    break;
                default:
                case 'public':
                    return $vKey;
            }

        }
    }
}

