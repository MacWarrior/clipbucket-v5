<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'define_php_links.php';
include_once 'upload_forms.php';

/**
 * This function is for Securing Password, you may change its combination for security reason but
 * make sure do not change once you made your script run
 * TODO : Multiple md5/sha1 is useless + this is totally unsecure, must be replaced by sha512 + salt
 *
 * @param $string
 *
 * @return string
 * @deprecated for security !
 *
 */
function pass_code_unsecure($string): string
{
    return md5(md5(sha1(sha1(md5($string)))));
}

function pass_code($string, $userid): string
{
    $salt = config('password_salt');
    return hash('sha512', $string . $userid . $salt);
}

/**
 * Clean a string and remove malicious stuff before insertion
 * that string into the database
 *
 * @param : { string } { $id } { string to be cleaned }
 *
 * @return string
 */
function mysql_clean($var): string
{
    return Clipbucket_db::getInstance()->clean_var($var);
}

function display_clean($var, $clean_quote = true): string
{
    if ($clean_quote) {
        return htmlentities($var, ENT_QUOTES);
    }
    return htmlentities($var);
}

function set_cookie_secure($name, $val, $time = null)
{
    if (is_null($time)) {
        $time = time() + 3600;
    }

    $path = '/';
    $flag_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
    $flag_httponly = true;

    if (version_compare(System::get_software_version('php_web'), '7.3.0', '>=')) {
        setcookie($name, $val, [
            'expires'  => $time,
            'path'     => $path,
            'secure'   => $flag_secure,
            'httponly' => $flag_httponly,
            'samesite' => 'Strict'
        ]);
    } else {
        setcookie($name, $val, $time, $path, '', $flag_secure, $flag_httponly);
    }
}

function getBytesFromFileSize($size)
{
    $units = [
        'B'  => 1,
        'kB' => 1024,
        'MB' => pow(1024, 2),
        'M'  => pow(1024, 2),
        'GB' => pow(1024, 3),
        'G'  => pow(1024, 3),
        'TB' => pow(1024, 4),
        'T'  => pow(1024, 4),
        'PB' => pow(1024, 5),
        'EB' => pow(1024, 6),
        'ZB' => pow(1024, 7),
        'YB' => pow(1024, 8)
    ];

    $size = trim($size);
    $unit = preg_replace('/[0-9.]/', '', $size);
    $size = preg_replace('/[^0-9]/', '', $size);
    if( !isset($units[$unit]) ) {
        $msg = 'getBytesFromFileSize - Unknown unit : ' . $unit;
        error_log($msg);
        DiscordLog::sendDump($msg);
    }
    return $size * $units[$unit];
}

/**
 * Generate random string of given length
 *
 * @param : { integer } { $length } { length of random string }
 *
 * @return string : { string } { $randomString  } { new generated random string }
 */
function RandomString($length): string
{
    $string = md5(microtime());
    $highest_startpoint = 32 - $length;
    return substr($string, rand(0, $highest_startpoint), $length);
}

/**
 * Function used to send emails. this is a very basic email function
 * you can extend or replace this function easily
 *
 * @param : { array } { $array } { array with all details of email }
 * @param bool $force force sending email even if emails are disabled
 * @return bool
 * @param_list : { content, subject, to, from, to_name, from_name }
 *
 * @throws Exception
 * @author : Arslan Hassan
 */
function cbmail($array, $force = false)
{
    if (config('disable_email') == 'yes' && !$force) {
        return false;
    }
    $from = $array['from'];
    if (!isValidEmail($from)) {
        error_log('Invalid sender email : ' . $from);
        return false;
    }

    $func_array = get_functions('email_functions');
    if (is_array($func_array)) {
        foreach ($func_array as $func) {
            if (function_exists($func)) {
                return $func($array);
            }
        }
    }

    $content = $array['content'];
    $subject = $array['subject'];
    $to = $array['to'];
    $to_name = $array['to_name'];
    $from_name = $array['from_name'];
    if ($array['nl2br']) {
        $content = nl2br($content);
    }

    # Checking Content
    if (preg_match('/<html>/', $content, $matches)) {
        if (empty($matches[1])) {
            $content = wrap_email_content($content);
        }
    }
    $message = $content;

    $mail = new PHPMailer(true); // defaults to using php "mail()"
    $mail_type = config('mail_type');
    //---Setting SMTP ---
    if ($mail_type == 'smtp') {
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host = config('smtp_host'); // SMTP server
        if (config('smtp_auth') == 'yes') {
            $mail->SMTPAuth = true;             // enable SMTP authentication
        }
        $mail->Port = config('smtp_port'); // set the SMTP port for the GMAIL server
        $mail->Username = config('smtp_user'); // SMTP account username
        $mail->Password = config('smtp_pass'); // SMTP account password
    }
    //--- Ending Smtp Settings
    $mail->SetFrom($from, $from_name);
    if (is_array($to)) {
        foreach ($to as $name) {
            $mail->AddAddress(strtolower($name), $to_name);
        }
    } else {
        $mail->AddAddress(strtolower($to), $to_name);
    }
    $mail->Subject = $subject;
    $mail->MsgHTML($message);

    if (!$mail->Send()) {
        if (has_access('admin_access', true)) {
            e("Mailer Error: " . $mail->ErrorInfo);
        }
        return false;
    }
    return true;
}

/**
 * Send email from PHP
 * @param $from
 * @param $to
 * @param $subj
 * @param $message
 *
 * @return bool
 * @throws Exception
 * @uses : { function : cbmail }
 */
function send_email($from, $to, $subj, $message)
{
    return cbmail(['from' => $from, 'to' => $to, 'subject' => $subj, 'content' => $message]);
}

/**
 * Function used to wrap email content in adds HTML AND BODY TAGS
 *
 * @param : { string } { $content } { contents of email to be wrapped }
 *
 * @return string
 */
function wrap_email_content($content): string
{
    return '<html><body>' . $content . '</body></html>';
}

/**
 * Function used to get file name
 *
 * @param : { string } { $file } { file path to get name for }
 *
 * @return bool|string
 */
function GetName($file)
{
    if (!is_string($file)) {
        return false;
    }
    //for server thumb files
    $parts = parse_url($file);
    $query = isset($query) ? parse_str($parts['query'], $query) : false;
    $get_file_name = $query['src'] ?? false;
    $path = explode('.', $get_file_name);
    $server_thumb_name = $path[0];
    if (!empty($server_thumb_name)) {
        return $server_thumb_name;
    }
    /*server thumb files END */
    $path = explode(DIRECTORY_SEPARATOR, $file);
    if (is_array($path)) {
        $file = $path[count($path) - 1];
    }
    return substr($file, 0, strrpos($file, '.'));
}

function old_set_time($temps): string
{
    $temps = round($temps);
    $heures = floor($temps / 3600);
    $minutes = round(floor(($temps - ($heures * 3600)) / 60));
    if ($minutes < 10) {
        $minutes = '0' . round($minutes);
    }
    $secondes = round($temps - ($heures * 3600) - ($minutes * 60));
    if ($secondes < 10) {
        $secondes = '0' . round($secondes);
    }
    return $minutes . ':' . $secondes;
}

/**
 * Function Used TO Get Extension Of File
 *
 * @param : { string } { $file } { file to get extension of }
 *
 * @return string : { string } { extension of file }
 *
 */
function getExt($file): string
{
    $parts = explode('.', $file);
    return strtolower(end($parts));
}

/**
 * Convert given seconds in Hours Minutes Seconds format
 *
 * @param : { integer } { $sec } { seconds to conver }
 * @param bool $padHours
 *
 * @return string : { string } { $hms } { formatted time string }
 */
function SetTime($sec, $padHours = true): string
{
    if (empty($sec)) {
        return '';
    }
    if ($sec < 3600) {
        return old_set_time($sec);
    }
    $hms = "";
    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hours = intval(intval($sec) / 3600);
    // add to $hms, with a leading 0 if asked for
    $hms .= ($padHours)
        ? str_pad($hours, 2, '0', STR_PAD_LEFT) . ':'
        : $hours . ':';
    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in
    // minutes past the hour: to get that, we need to
    // divide by 60 again and keep the remainder
    $minutes = intval(($sec / 60) % 60);
    // then add to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':';
    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $seconds = intval($sec % 60);
    // add to $hms, again with a leading 0 if needed
    $hms .= str_pad($seconds, 2, '0', STR_PAD_LEFT);
    return $hms;
}

/**
 * Checks if provided email is valid or not
 *
 * @param : { string } { $email } { email address to check }
 *
 * @return mixed
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/**
 * Get Directory Size - get_video_file($vdata,$no_video,false);
 *
 * @param string $path : path to directory to determine size of
 * @param array $excluded : array of files to be ignored in count
 * @return array : { integer } { $total } { size of directory }
 */
function get_directory_size(string $path, array $excluded = []): array
{
    $totalsize = 0;
    $totalcount = 0;
    $dircount = 0;
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            $nextpath = $path . $file;
            if ($file != '.' && $file != '..' && !is_link($nextpath)) {
                if (is_dir($nextpath)) {
                    $dircount++;
                    $result = get_directory_size($nextpath);
                    $totalsize += $result['size'];
                    $totalcount += $result['count'];
                    $dircount += $result['dircount'];
                } elseif (is_file($nextpath)
                    && !array_filter($excluded, function ($value) use ($nextpath) {
                        return strpos($nextpath, $value) !== false;
                    })
                ) {
                    $totalsize += filesize($nextpath);
                    $totalcount++;
                }
            }
        }
        closedir($handle);
    }
    $total['size'] = $totalsize;
    $total['count'] = $totalcount;
    $total['dircount'] = $dircount;
    return $total;
}

/**
 * TODO delete func => call instead System::get_readable_filesize
 *
 * @param : { integer } { $data } { size in bytes }
 *
 * @return string : { string } { $data } { file size in readable format }
 */
function formatfilesize($data): string
{
    return System::get_readable_filesize($data, 2);
}

function getCommentAdminLink($type, $id): string
{
    switch($type){
        default:
        case 'v':
            return '/admin_area/edit_video.php?video=' . $id;
        case 'p':
            return '/admin_area/edit_photo.php?photo=' . $id;
        case 'cl':
            return '/admin_area/edit_collection.php?collection=' . $id;
    }
}

/**
 * FUNCTION USED TO GET ADVERTISMENT
 *
 * @param : { array } { $params } { array of parameters }
 *
 * @return string
 * @throws Exception
 */
function getAd($params): string
{
    global $adsObj;
    $data = '';
    if (isset($params['style']) || isset($params['class']) || isset($params['align'])) {
        $data .= '<div style="' . $params['style'] . '" class="' . $params['class'] . '" align="' . $params['align'] . '">';
    }
    $data .= ad($adsObj->getAd($params['place']));
    if (isset($params['style']) || isset($params['class']) || isset($params['align'])) {
        $data .= '</div>';
    }
    return $data;
}

/**
 * FUNCTION USED TO GET THUMBNAIL, MADE FOR SMARTY
 *
 * @param : { array } { $params } { array of parameters }
 *
 * @return mixed
 * @throws Exception
 */
function getSmartyThumb($params)
{
    return get_thumb($params['vdetails'], $params['multi'], $params['size']);
}

/**
 * FUNCTION USED TO MAKE TAGS MORE PERFECT
 * @param : { string } { $tags } { text unformatted }
 * @param string $sep
 *
 * @return string : { string } { $tagString } { text formatted }
 * @author : Arslan Hassan <arslan@clip-bucket.com,arslan@labguru.com>
 *
 */
function genTags($tags, $sep = ','): string
{
    //Remove fazool spaces
    $tags = preg_replace(['/ ,/', '/, /'], ',', $tags);
    $tags = preg_replace('`[,]+`', ',', $tags);
    $tag_array = explode($sep, $tags);
    $newTags = [];
    foreach ($tag_array as $tag) {
        if (isValidtag($tag)) {
            $newTags[] = $tag;
        }
    }
    //Creating new tag string
    if (is_array($newTags)) {
        return implode(',', $newTags);
    }
    return 'no-tag';
}

/**
 * FUNCTION USED TO VALIDATE TAG
 * @param { string } { $tag } { tag to be validated }
 *
 * @return bool : { boolean } { true or false }
 * @author : Arslan Hassan <arslan@clip-bucket.com,arslan@labguru.com>
 *
 */
function isValidtag($tag): bool
{
    if (strlen($tag) <= 128 && strlen($tag) >= 3) {
        return true;
    }
    return false;
}

/**
 * FUNCTION USED TO GET CATEGORY LIST
 *
 * @param array $params
 *
 * @return array|bool|string|void : { array } { $cats } { array of categories }
 * @throws Exception
 * @internal param $ : { array } { $params } { array of parameters e.g type } { $params } { array of parameters e.g type }
 */
function getCategoryList($params = [])
{
    $params['echo'] = $params['echo'] ?: false;
    $version = Update::getInstance()->getDBVersion();
    switch ($params['type']) {
        default:
            cb_call_functions('categoryListing', $params);
            break;

        case 'video':
        case 'videos':
        case 'v':
            $type = 'video';
            break;

        case 'users':
        case 'user':
        case 'u':
        case 'channels':
            $type = 'user';
            break;
        case 'collection':
        case 'collections':
        case 'cl':
            $type = 'collection';
            break;
        case 'photo':
            $type = 'photo';
            break;
    }
    $cats = [];
    if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
        $params['category_type'] = Category::getInstance()->getIdsCategoriesType($type);
        $params['parent_only'] = true;
        $cats = Category::getInstance()->getAll($params);
        foreach ($cats as &$cat) {
            $cat['children'] = Category::getInstance()->getChildren($cat['category_id']);
        }
    }
    if (!empty($params['with_all'])) {
        $cats[] = ['category_id' => 'all', 'category_name' => lang('cat_all')];
    }
    if (!empty($params['echo'])) {
        echo CBvideo::getInstance()->displayDropdownCategory($cats, $params);
        return;
    }

    return $cats;
}

/**
 * Get list of categories from smarty
 * @param $params
 *
 * @return array|bool|string
 * @throws Exception
 * @uses { function : getCategoryList }
 *
 */
function getSmartyCategoryList($params)
{
    return getCategoryList($params);
}

/**
 * Function used to insert data in database
 * @param      $tbl
 * @param      $flds
 * @param      $vls
 * @param null $ep
 * @throws Exception
 * @uses : { class : $db } { function : dbInsert }
 */
function dbInsert($tbl, $flds, $vls, $ep = null)
{
    Clipbucket_db::getInstance()->insert($tbl, $flds, $vls, $ep);
}

/**
 * An easy function for errors and messages (e is basically short form of exception)
 * I don't want to use the whole Trigger and Exception code, so e pretty works for me :D
 *
 * @param null $msg
 * @param string $type
 * @param bool $secure
 *
 * @return array|void
 * @internal param $ { string } { $msg } { message to display }
 * @internal param $ { string } { $type } { e for error and m for message }
 * @internal param $ { integer } { $id } { Any Predefined Message ID }
 */
function e($msg = null, $type = 'e', $secure = true)
{
    global $eh;
    if (!empty($msg)) {
        return $eh->e($msg, $type, $secure);
    }
}

/**
 * Print an array in pretty way
 *
 * @param : { string / array } { $text } { Element to be printed }
 * @param bool $pretty
 */
function pr($text, $pretty = false)
{
    if (!$pretty) {
        $dump = print_r($text, true);
        echo display_clean($dump);
    } else {
        echo '<pre>';
        $dump = print_r($text, true);
        echo display_clean($dump);
        echo '</pre>';
    }
}

/**
 * Function used to get userid anywhere
 * if there is no user_id it will return false
 * @uses : { class : $userquery } { var : userid }
 */
function user_id()
{
    if (userquery::getInstance()->userid != '' && userquery::getInstance()->is_login) {
        return userquery::getInstance()->userid;
    }
    return false;
}

/**
 * Function used to get username anywhere
 * if there is no usern_name it will return false
 * @uses : { class : $userquery } { var : $username }
 */
function user_name()
{
    if (userquery::getInstance()->user_name) {
        return userquery::getInstance()->user_name;
    }
    return userquery::getInstance()->get_logged_username();
}

function user_email()
{
    if (userquery::getInstance()->email) {
        return userquery::getInstance()->email;
    }
    return false;
}
function user_dob()
{
    if (userquery::getInstance()->udetails['dob']) {
        return userquery::getInstance()->udetails['dob'];
    }
    return false;
}

/**
 * Function used to check weather user access or not
 * @param      $access
 * @param bool $check_only
 * @param bool $verify_logged_user
 *
 * @return bool
 * @throws Exception
 * @uses : { class : $userquery } { function : login_check }
 */
function has_access($access, $check_only = true, $verify_logged_user = true): bool
{
    return userquery::getInstance()->login_check($access, $check_only, $verify_logged_user);
}

/**
 * Function used to return mysql time
 * @return false|string : { current time }
 * @author : Fwhite
 */
function NOW()
{
    return date('Y-m-d H:i:s', time());
}

/**
 * Check if syntax is valid
 * @param $code
 * @param $text
 *
 * @return bool
 * @uses : { function : validate_field }
 *
 */
function is_valid_syntax($code, $text): bool
{
    switch ($code) {
        case 'username':
            $pattern = '^[A-Za-z0-9_.]+$';
            break;
        case 'email':
            $pattern = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$';
            break;
        case 'field_text':
            $pattern = '^[_a-z0-9-]+$';
            break;
        default:
            return true;
    }

    preg_match('/' . $pattern . '/i', $text, $matches);
    if (!empty($matches[0])) {
        return true;
    }
    return false;
}

/**
 * Function used to apply function on a value
 *
 * @param $func
 * @param $val
 *
 * @return bool
 */
function is_valid_value($func, $val): bool
{
    if (!function_exists($func)) {
        return true;
    }
    if (!$func($val)) {
        return false;
    }
    return true;
}

/**
 * Calls an array of functions with parameters
 *
 * @param : { array } { $func } { array with functions to be called }
 * @param : { string } { $val } { parameters for functions }
 *
 * @return mixed
 */
function apply_func($func, $val)
{
    if (is_array($func)) {
        foreach ($func as $f) {
            if (function_exists($f)) {
                $val = $f($val);
            }
        }
    } else {
        $val = $func($val);
    }
    return $val;
}

/**
 * Function used to validate YES or NO input
 *
 * @param : { string } { $input } { field to be checked }
 *
 * @param $return
 *
 * @return string
 */
function yes_or_no($input, $return = 'yes'): string
{
    $input = strtolower($input);
    if ($input != 'yes' && $input != 'no') {
        return $return;
    }
    return $input;
}

/**
 * Function used to validate collection category
 * @param null $array
 *
 * @return bool
 * @throws Exception
 * @uses : { class : $cbcollection } { function : validate_collection_category }
 */
function validate_collection_category($array = null)
{
    global $cbcollection;
    return $cbcollection->validate_collection_category($array);
}

/**
 * Function used to get user avatar
 *
 * @param { array } { $param } { array with parameters }
 * @params_in_$param : details, size, uid
 *
 * @return string
 * @throws Exception
 * @uses : { class : $userquery } { function : avatar }
 */
function avatar($param)
{
    $udetails = $param['details'];
    $size = $param['size'];
    $uid = $param['uid'];
    return userquery::getInstance()->getUserThumb($udetails, $size, $uid);
}

/**
 * This function used to call function dynamically in smarty
 *
 * @param : { array } { $param } { array with parameters e.g $param['name'] }
 *
 * @return mixed|void
 */
function load_form($param)
{
    $func = $param['name'];
    $class = $param['function_class'] ?? '';
    if (!empty($class) && method_exists($class, $func)) {
        return $class::$func($param);
    }

    if (function_exists($func)) {
        return $func($param);
    }

    error_log('Unknown method : ' . $func . ' for class : ' . $class);
}

/**
 *
 * @param : { string } { $string } { string to decode }
 *
 * @return string
 */
function unhtmlentities($string): string
{
    $trans_tbl = get_html_translation_table(HTML_ENTITIES);
    $trans_tbl = array_flip($trans_tbl);
    return strtr($string, $trans_tbl);
}

/**
 * Function used to get array value
 * if you know partial value of array and wants to know complete
 * value of an array, this function is being used then
 *
 * @param $needle
 * @param $haystack
 *
 * @return mixed|void
 * @internal param $ : { string / int } { $needle } { element to find } { $needle } { element to find }
 * @internal param $ : { array / string }  { $haystack } { element to do search in }  { $haystack } { element to do search in }
 */
function array_find($needle, $haystack)
{
    foreach ($haystack as $item) {
        if (strpos($item, $needle) !== false) {
            return $item;
        }
    }
}

/**
 * Function used to give output in proper form
 *
 * @param : { array } { $params } { array of parameters e.g $params['input'] }
 *
 * @return mixed : { string } { string value depending on input type }
 * { string value depending on input type }
 */
function input_value($params)
{
    $input = $params['input'];
    $value = $input['value'];
    if ($input['value_field'] == 'checked') {
        $value = $input['checked'];
    }

    if ($input['return_checked']) {
        return display_clean($input['checked']);
    }

    if (function_exists($input['display_function'])) {
        return $input['display_function']($value);
    }

    if ($input['type'] == 'dropdown') {
        if ($input['checked']) {
            return display_clean($value[$input['checked']]);
        }
        return display_clean($value[0]);
    }
    return display_clean($input['value']);
}

/**
 * Function used to convert input to categories
 * @param { string / array } { $input } { categories to be converted e.g #12# }
 * @throws Exception
 */
function convert_to_categories($input)
{
    if (is_array($input)) {
        foreach ($input as $in) {
            if (is_array($in)) {
                foreach ($in as $i) {
                    if (is_array($i)) {
                        foreach ($i as $info) {
                            $cat_details = Category::getInstance()->getById($info);
                            $cat_array[] = [$cat_details['category_id'], $cat_details['category_name']];
                        }
                    } elseif (is_numeric($i)) {
                        $cat_details = Category::getInstance()->getById($i);
                        $cat_array[] = [$cat_details['category_id'], $cat_details['category_name']];
                    }
                }
            } elseif (is_numeric($in)) {
                $cat_details = Category::getInstance()->getById($in);
                $cat_array[] = [$cat_details['category_id'], $cat_details['category_name']];
            }
        }
    }
    $count = 1;
    if (is_array($cat_array)) {
        foreach ($cat_array as $cat) {
            echo '<a href="' . $cat[0] . '">' . $cat[1] . '</a>';
            if ($count != count($cat_array)) {
                echo ', ';
            }
            $count++;
        }
    }
}


/**
 * Sharing OPT displaying
 *
 * @param $input
 *
 * @return int|string|void
 */
function display_sharing_opt($input)
{
    foreach ($input as $key => $i) {
        return $key;
    }
}

/**
 * Function used to get number of videos uploaded by user
 * @param      $uid
 * @param null $cond
 * @param bool $count_only
 *
 * @return array|bool|int
 * @throws Exception
 * @uses : { class : $userquery } { function : get_user_vids }
 */
function get_user_vids($uid, $cond = null, $count_only = false)
{
    return userquery::getInstance()->get_user_vids($uid, $cond, $count_only);
}

function error_list(): array
{
    global $eh;
    return $eh->get_error();
}

function warning_list(): array
{
    global $eh;
    return $eh->get_warning();
}


function msg_list(): array
{
    global $eh;
    return $eh->get_message();
}

/**
 * Function used to add template in display template list
 *
 * @param : { string } { $file } { file of the template }
 * @param bool $folder
 * @param bool $follow_show_page
 */
function template_files($file, $folder = false, $follow_show_page = true)
{
    if (!$folder) {
        ClipBucket::getInstance()->template_files[] = ['file' => $file, 'follow_show_page' => $follow_show_page];
    } else {
        ClipBucket::getInstance()->template_files[] = ['file' => $file, 'folder' => $folder, 'follow_show_page' => $follow_show_page];
    }
}

/**
 * Function used to include file
 *
 * @param : { array } { $params } { paramets inside array e.g $param['file'] }
 *
 * @action : { displays template }
 */
function include_template_file($params)
{
    $file = $params['file'];
    if (file_exists(LAYOUT . DIRECTORY_SEPARATOR . $file)) {
        Template($file);
    } elseif (file_exists($file)) {
        Template($file, false);
    }
}

/**
 * Function used to validate username
 *
 * @param : { string } { $username } { username to be checked }
 *
 * @return bool : { boolean } { true or false depending on situation }
 * @throws Exception
 */
function username_check($username): bool
{
    global $Cbucket;
    $banned_words = $Cbucket->configs['disallowed_usernames'];
    $banned_words = explode(',', $banned_words);
    foreach ($banned_words as $word) {
        preg_match("/$word/Ui", $username, $match);
        if (!empty($match[0])) {
            return false;
        }
    }
    //Checking if its syntax is valid or not
    $multi = config('allow_unicode_usernames');

    //Checking Spaces
    if (!config('allow_username_spaces')) {
        preg_match('/ /', $username, $matches);
    }
    if (!is_valid_syntax('username', $username) && $multi != 'yes' || $matches) {
        e(lang("class_invalid_user"));
    }
    if (!preg_match('/^[A-Za-z0-9_.]+$/', $username)) {
        return false;
    }
    return true;
}

/**
 * Function used to check weather username already exists or not
 * @param $user
 *
 * @return bool
 * @throws Exception
 * @uses : { class : $userquery } { function : username_exists }
 */
function user_exists($user): bool
{
    return userquery::getInstance()->username_exists($user);
}

/**
 * Function used to check weather email already exists or not
 *
 * @param : { string } { $user } { email address to check }
 *
 * @return bool
 * @uses : { class : $userquery } { function : duplicate_email }
 */
function email_exists($user): bool
{
    return userquery::getInstance()->duplicate_email($user);
}

function check_email_domain($email): bool
{
    return userquery::getInstance()->check_email_domain($email);
}

/**
 * Function used to check weather error exists or not
 *
 * @param string $param
 *
 * @return array|bool
 */
function error($param = 'array')
{
    global $eh;
    $error = $eh->get_error();
    if (count($error) > 0) {
        if ($param != 'array') {
            if ($param == 'single') {
                $param = 0;
            }
            return $error[$param];
        }
        return $error;
    }
    return false;
}

function warning($param = 'array')
{
    global $eh;
    $error = $eh->get_warning();
    if (count($error) > 0) {
        if ($param != 'array') {
            if ($param == 'single') {
                $param = 0;
            }
            return $error[$param];
        }
        return $error;
    }
    return false;
}

/**
 * Function used to check weather msg exists or not
 *
 * @param string $param
 *
 * @return array|bool
 */
function msg($param = 'array')
{
    global $eh;
    $message = $eh->get_message();
    if (count($message) > 0) {
        if ($param != 'array') {
            if ($param == 'single') {
                $param = 0;
            }
            return $message[$param];
        }
        return $message;
    }
    return false;
}

/**
 * Function used to load plugin
 */
function load_plugin()
{
    global $cbplugin;
}

/**
 * Function used to create limit function from current page & results
 *
 * @param $page
 * @param $result
 *
 * @return string
 */
function create_query_limit($page, $result): string
{
    if (empty($page) || $page == 0 || !is_numeric($page)) {
        $page = 1;
    }
    $from = $page - 1;
    $from = $from * $result;
    return mysql_clean($from) . ',' . mysql_clean($result);
}

/**
 * Function used to get value from $_GET
 *
 * @param : { string } { $val } { value to fetch from $_GET }
 * @param bool $filter
 *
 * @return bool|string
 */
function get_form_val($val, bool $filter = false)
{
    if ($filter) {
        return isset($_GET[$val]) ? display_clean($_GET[$val]) : false;
    }
    return $_GET[$val];
}

/**
 * Function used to get value from $_GET
 * @param $val
 *
 * @return bool|string
 * @uses : { function : get_form_val }
 *
 */
function get($val)
{
    return get_form_val($val);
}

/**
 * Function used to get value from $_POST
 *
 * @param : { string } { $val } { value to fetch from $_POST }
 * @param bool $filter
 *
 * @return string
 */
function post_form_val($val, $filter = false)
{
    if ($filter) {
        return display_clean($_POST[$val]);
    }
    return $_POST[$val];
}

/**
 * Function used to return LANG variable
 *
 * @param      $var
 * @param $params
 * @return array|string|string[]
 * @throws Exception
 */
function lang($var, $params = [])
{
    if ($var == '') {
        return '';
    }

    if (empty(Language::getInstance()->arrayTranslation[$var])) {
        //check default value in db
        $translation = Language::getInstance()->getTranslationByKey($var, Language::$english_id)['translation'];

        if (!array_key_exists($var, Language::getInstance()->arrayTranslation)) {
            $translation = $var;

            if( Language::getInstance()->isTranslationSystemInstalled() ){
                $msg = '[LANG] Missing translation for "' . $var . '"' . PHP_EOL;
                error_log($msg);

                if (in_dev()) {
                    DiscordLog::sendDump($msg);

                    $string = debug_backtrace_string();
                    DiscordLog::sendDump($string);

                    /** Splitting the log message into 100-character chunks to avoid saturating the error_log buffer */
                    $chunks = str_split($string, 1000);
                    foreach ($chunks as $chunk) {
                        error_log($chunk);
                    }
                }
            }
        }
    } else {
        $translation = Language::getInstance()->arrayTranslation[$var];
    }

    $array_str = ['{title}'];
    $array_replace = ['Title'];
    $lang = str_replace($array_str, $array_replace, $translation);
    if( empty($params) ){
        return $lang;
    }

    if( !is_array($params) ){
        $params = [$params];
    }

    return vsprintf($lang, $params);
}

/**
 * @return mixed
 * @throws Exception
 */
function get_current_language()
{
    return Language::getDefaultLanguage()['language_code'];
}

/**
 * Fetch lang value from smarty using lang code
 *
 * @param : { array } { $param } { array of parameters }
 *
 * @return array|string|string[]|void
 * @throws Exception
 * @uses : { function lang() }
 */
function smarty_lang($param)
{
    if (getArrayValue($param, 'assign') == '') {
        return lang($param['code']);
    }
    assign($param['assign'], lang($param['code']));
}

/**
 * Get an array element by key
 *
 * @param array $array
 * @param bool $key
 *
 * @return bool|mixed : { value / false } { element value if found, else false }
 * @internal param $ : { array } { $array } { array to check for element } { $array } { array to check for element }
 * @internal param $ : { string / integeger } { $key } { element name or key } { $key } { element name or key }
 */
function getArrayValue($array = [], $key = false)
{
    if (!empty($array) && $key) {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return false;
    }
    return false;
}

/**
 * Fetch value of a constant
 *
 * @param bool $constantName
 *
 * @return bool|mixed : { val / false } { constant value if found, else false }
 * @internal param $ : { string } { $constantName } { false by default, name of constant } { $constantName } { false by default, name of constant }
 * @ref: { http://php.net/manual/en/function.constant.php }
 */
function getConstant($constantName = false)
{
    if ($constantName && defined($constantName)) {
        return constant($constantName);
    }
    return false;
}

/**
 * Function used to assign link
 *
 * @param : { array } { $params } { an array of parameters }
 * @param bool $fullurl
 *
 * @return string|void
 */
function cblink($params, $fullurl = false)
{
    $name = getArrayValue($params, 'name');
    if ($name == 'category') {
        return category_link($params['data'], $params['type']);
    }
    if ($name == 'sort') {
        return sort_link($params['sort'], 'sort', $params['type']);
    }
    if ($name == 'time') {
        return sort_link($params['sort'], 'time', $params['type']);
    }
    if ($name == 'tag') {
        return '/search_result.php?query=' . urlencode($params['tag']) . '&type=' . $params['type'];
    }
    if ($name == 'category_search') {
        return '/search_result.php?category[]=' . $params['category'] . '&type=' . $params['type'];
    }

    $val = 1;
    if (defined('SEO') && SEO != 'yes') {
        $val = 0;
    }

    if ($fullurl) {
        $link = BASEURL;
    } else {
        $link = '';
    }

    if (isset(ClipBucket::getInstance()->links[$name])) {
        if (strpos(get_server_protocol(), ClipBucket::getInstance()->links[$name][$val]) !== false) {
            $link .= ClipBucket::getInstance()->links[$name][$val];
        } else {
            $link .= '/' . ClipBucket::getInstance()->links[$name][$val];
        }
    } else {
        $link = false;
    }

    $param_link = '';
    if (!empty($params['extra_params'])) {
        preg_match('/\?/', $link, $matches);
        if (!empty($matches[0])) {
            $param_link = '&' . $params['extra_params'];
        } else {
            $param_link = '?' . $params['extra_params'];
        }
    }

    if (isset($params['assign'])) {
        assign($params['assign'], $link . $param_link);
    } else {
        return $link . $param_link;
    }
}

/**
 * Function used to show rating
 *
 * @param : { array } { $params } { array of parameters }
 *
 * @return string
 */
function show_rating($params)
{
    $class = $params['class'] ? $params['class'] : 'rating_stars';
    $rating = $params['rating'];
    $ratings = $params['ratings'];
    $total = $params['total'];
    $style = $params['style'];
    if (empty($style)) {
        $style = config('rating_style');
    }

    if ($total <= 10) {
        $total = 10;
    }
    $perc = $rating * 100 / $total;
    $disperc = 100 - $perc;
    if ($ratings <= 0 && $disperc == 100) {
        $disperc = 0;
    }

    $perc = $perc . '%';
    $disperc = $disperc . '%';
    switch ($style) {
        case 'percentage':
        case 'percent':
        case 'perc':
        default:
            $likeClass = 'UserLiked';
            if (str_replace('%', '', $perc) < '50') {
                $likeClass = 'UserDisliked';
            }
            $ratingTemplate = '<div class="' . $class . '">
									<div class="ratingContainer">
										<span class="ratingText">' . $perc . '</span>';
            if ($ratings > 0) {
                $ratingTemplate .= ' <span class="' . $likeClass . '">&nbsp;</span>';
            }
            $ratingTemplate .= '</div></div>';
            break;

        case 'bars':
        case 'Bars':
        case 'bar':
            $ratingTemplate = '<div class="' . $class . '">
					<div class="ratingContainer">
						<div class="LikeBar" style="width:' . $perc . '"></div>
						<div class="DislikeBar" style="width:' . $disperc . '"></div>
					</div>
				</div>';
            break;

        case 'numerical':
        case 'numbers':
        case 'number':
        case 'num':
            $likes = round($ratings * $perc / 100);
            $dislikes = $ratings - $likes;
            $ratingTemplate = '<div class="' . $class . '">
					<div class="ratingContainer">
						<div class="ratingText">
							<span class="LikeText">' . $likes . ' Likes</span>
							<span class="DislikeText">' . $dislikes . ' Dislikes</span>
						</div>
					</div>
				</div>';
            break;

        case 'custom':
            $file = LAYOUT . DIRECTORY_SEPARATOR . $params['file'];
            if (!empty($params['file']) && file_exists($file)) {
                // File exists, lets start assign things
                assign('perc', $perc);
                assign('disperc', $disperc);
                // Likes and Dislikes
                $likes = floor($ratings * $perc / 100);
                $dislikes = $ratings - $likes;
                assign('likes', $likes);
                assign('dislikes', $dislikes);
                Template($file, false);
            } else {
                $params['style'] = 'percent';
                return show_rating($params);
            }
            break;
    }
    return $ratingTemplate;
}

/**
 * Function used to display an ad
 *
 * @param $in
 *
 * @return string
 */
function ad($in): string
{
    return stripslashes($in);
}

/**
 * Function used to get available function list
 * for special place , read docs.clip-bucket.com
 *
 * @param $name
 *
 * @return bool|array
 */
function get_functions($name)
{
    global $Cbucket;
    if (isset($Cbucket->$name)) {
        $funcs = $Cbucket->$name;
        if (is_array($funcs) && count($funcs) > 0) {
            return $funcs;
        }
        return false;
    }
}

/**
 * Function used to add js in ClipBuckets JSArray
 * @param $files
 * @throws Exception
 * @uses { class : $Cbucket } { function : addJS }
 *
 */
function add_js($files)
{
    ClipBucket::getInstance()->addJS($files);
}

/**
 * Function add_header()
 * this will be used to add new files in header array
 * this is basically for plugins
 * for specific page array('page'=>'file')
 * ie array('uploadactive'=>'datepicker.js')
 *
 * @param $files
 * @uses : { class : $Cbucket } { function : add_header }
 *
 */
function add_header($files)
{
    global $Cbucket;
    ClipBucket::getInstance()->add_header($files);
}

/**
 * Adds admin header
 * @param $files
 * @uses : { class : $Cbucket } { function : add_admin_header }
 *
 */
function add_admin_header($files)
{
    global $Cbucket;
    ClipBucket::getInstance()->add_admin_header($files);
}

/**
 * Functions used to call functions when users views a channel
 * @param : { array } { $u } { array with details of user }
 * @throws Exception
 */
function call_view_channel_functions($u)
{
    $funcs = get_functions('view_channel_functions');
    if (is_array($funcs) && count($funcs) > 0) {
        foreach ($funcs as $func) {
            if (function_exists($func)) {
                $func($u);
            }
        }
    }
    increment_views($u['userid'], 'channel');
}

/**
 * Functions used to call functions when users views a collection
 * @param : { array } { $cdetails } { array with details of collection }
 * @throws Exception
 */
function call_view_collection_functions($cdetails)
{
    $funcs = get_functions('view_collection_functions');
    if (is_array($funcs) && count($funcs) > 0) {
        foreach ($funcs as $func) {
            if (function_exists($func)) {
                $func($cdetails);
            }
        }
    }
}

/**
 * Function used to increment views of an object
 *
 * @param      $id
 * @param null $type
 *
 * @throws Exception
 * @internal param $ : { string } { $type } { type of object e.g video, user } { $type } { type of object e.g video, user }
 * @action : database updating
 * @internal param $ : { integer } { $id } { id of element to update views for } { $id } { id of element to update views for }
 */
function increment_views($id, $type = null)
{
    switch ($type) {
        case 'v':
        case 'video':
        default:
            if (!isset($_COOKIE['video_' . $id])) {
                $currentTime = time();
                $views = (int)$videoViewsRecord['video_views'] + 1;
                Clipbucket_db::getInstance()->update(tbl('video_views'), ['video_views', 'last_updated'], [$views, $currentTime], " video_id='$id' OR videokey='$id'");
                $query = "UPDATE " . tbl("video_views") . " SET video_views = video_views + 1 WHERE video_id = {$id}";
                Clipbucket_db::getInstance()->execute($query);
                set_cookie_secure('video_' . $id, 'watched');
            }
            break;

        case 'u':
        case 'user':
        case 'channel':
            if (!isset($_COOKIE['user_' . $id])) {
                Clipbucket_db::getInstance()->update(tbl("users"), ['profile_hits'], ['|f|profile_hits+1'], " userid='$id'");
                set_cookie_secure('user_' . $id, 'watched');
            }
            break;

        case 'photos':
        case 'photo':
        case 'p':
            if (!isset($_COOKIE['photo_' . $id])) {
                Clipbucket_db::getInstance()->update(tbl('photos'), ['views', 'last_viewed'], ['|f|views+1', NOW()], " photo_id = '$id'");
                set_cookie_secure('photo_' . $id, 'viewed');
            }
            break;
    }

}

/**
 * Function used to increment views of an object
 *
 * @param      $id
 * @param null $type
 *
 * @throws Exception
 * @internal param $ : { string } { $type } { type of object e.g video, user } { $type } { type of object e.g video, user }
 * @action : database updating
 * @internal param $ : { integer } { $id } { id of element to update views for } { $id } { id of element to update views for }
 */
function increment_views_new($id, $type = null)
{
    switch ($type) {
        case 'v':
        case 'video':
        default:
            $vdetails = get_video_details($id);
            $sessionTime =  ($vdetails['duration'] ?? 3600);
            if (!isset($_SESSION['video_' . $id]) || ( time() - $_SESSION['video_' . $id]  > $sessionTime) ) {
                Clipbucket_db::getInstance()->update(tbl('video'), ['views', 'last_viewed'], ['|f|views+1', '|f|NOW()'], " videokey='$id'");
                if (config('enable_video_view_history') == 'yes') {
                    Clipbucket_db::getInstance()->insert(tbl('video_views'), ['id_video', 'id_user', 'view_date'], [$vdetails['videoid'], (user_id() ?: 0), '|f|NOW()']);
                }
                $_SESSION['video_' . $id] = time();

                $userid = user_id();
                if ($userid) {
                    $log_array = [
                        'success'       => 'NULL',
                        'action_obj_id' => $id,
                        'userid'        => $userid,
                        'details'       => $vdetails['title']
                    ];
                    insert_log('Watch a video', $log_array);
                }
            }
            break;

        case 'u':
        case 'user':
        case 'channel':
            if (!isset($_COOKIE['user_' . $id])) {
                Clipbucket_db::getInstance()->update(tbl('users'), ['profile_hits'], ['|f|profile_hits+1'], " userid='$id'");
                set_cookie_secure('user_' . $id, 'watched');
            }
            break;

        case 'photos':
        case 'photo':
        case 'p':
            if (!isset($_COOKIE['photo_' . $id])) {
                Clipbucket_db::getInstance()->update(tbl('photos'), ['views', 'last_viewed'], ['|f|views+1', NOW()], " photo_id = '$id'");
                set_cookie_secure('photo_' . $id, 'viewed');
            }
            break;
    }

}

/**
 * Function used to get post var
 *
 * @param : { string } { $var } { variable to get value for }
 *
 * @return mixed
 */
function post($var)
{
    if (isset($_POST[$var])) {
        return $_POST[$var];
    }
    return '';
}

/**
 * Function used to show flag form
 * @param : { array } { $array } { array of parameters }
 * @throws Exception
 */
function show_share_form($array)
{
    assign('params', $array);

    $contacts = userquery::getInstance()->get_contacts(user_id());
    assign('contacts', $contacts);
    Template('blocks/common/share.html');
}

/**
 * Function used to show flag form
 * @param : { array } { $array } { array of parameters }
 */
function show_flag_form($array)
{
    assign('params', $array);
    Template('blocks/common/report.html');
}

/**
 * Function used to show playlist form
 * @param : { array } { $array } { array of parameters }
 */
function show_playlist_form($array)
{
    global $cbvid;

    assign('params', $array);
    assign('type', $array['type']);
    // decides to show all or user only playlists
    // depending on the parameters passed to it
    $params = [
        'type'=>$array['type']
    ];
    if (!empty($array['user'])) {
        $params['userid'] = $array['user'];
    } elseif (user_id()) {
        $params['userid'] = user_id();
    }
    $playlists = Playlist::getInstance()->getAll($params);
    assign('playlists', $playlists);
    Template('blocks/common/playlist.html');
}

/**
 * Function used to show collection form
 * @throws Exception
 * @internal param $ : { array } { $params } { array with parameters }
 */

/**
 * Convert timestamp to date
 *
 * @param null $format
 * @param null $timestamp
 *
 * @return false|string : { string } { time formatted into date }
 * @internal param $ : { string } { $format } { current format of date } { $format } { current format of date }
 * @internal param $ : { string } { $timestamp } { time to be converted to date } { $timestamp } { time to be converted to date }
 */
function cbdate($format = null, $timestamp = null)
{
    if (!$format) {
        $format = DATE_FORMAT;
    }

    if (is_string($timestamp)) {
        $timestamp = strtotime($timestamp);
    }

    if ($timestamp < 0) {
        return 'N/A';
    }

    if (!$timestamp) {
        return date($format);
    }

    return date($format, $timestamp);
}

function cbdatetime($format = null, $timestamp = null)
{
    if (!$format) {
        $format = DATE_FORMAT . ' h:m:s';
    }

    return cbdate($format, $timestamp);
}

/**
 * Function used to count pages and return total divided
 *
 * @param $total
 * @param $count
 *
 * @return float : { integer } { $total_pages }
 * @internal param $ { integer } { $total } { total number of pages }
 * @internal param $ { integer } { $count } { number of pages to be displayed }
 */
function count_pages($total, $count)
{
    if (empty($total)){
        return 0;
    }
    if ($count < 1) {
        $count = 1;
    }
    $records = $total / $count;
    return (int)round($records + 0.49, 0);
}

/**
 * Fetch user level against a given userid
 * @param $id
 *
 * @return
 * @uses : { class : $userquery } { function : usr_levels() }
 *
 */
function get_user_level($id)
{
    return userquery::getInstance()->usr_levels[$id];
}

/**
 * This function used to check weather user is online or not
 *
 * @param : { string } { $time } { last active time }
 * @param string $margin
 *
 * @return string : { string  }{ status of user e.g online or offline }
 * @throws Exception
 */
function is_online($time, $margin = '5'): string
{
    $margin = $margin * 60;
    $active = strtotime($time);
    $curr = time();
    $diff = $curr - $active;
    if ($diff > $margin) {
        return lang('offline');
    }
    return lang('online');
}

/**
 * ClipBucket Form Validator
 * this function controls the whole logic of how to operate input
 * validate it, generate proper error
 *
 * @param $input
 * @param $array
 *
 * @throws Exception
 * @internal param $ : { array } { $input } { array of form values } { $input } { array of form values }
 * @internal param $ : { array } { $array } { array of form fields } { $array } { array of form fields }
 */
function validate_cb_form($input, $array)
{
    //Check the Collpase Category Checkboxes
    if (is_array($input)) {
        foreach ($input as $field) {
            $funct_err = false;
            $field['name'] = formObj::rmBrackets($field['name']);
            $title = $field['title'];
            $val = $array[$field['name']];
            $req = $field['required'];
            $invalid_err = $field['invalid_err'];
            $function_error_msg = $field['function_error_msg'];
            if (is_string($val)) {
                if (!isUTF8($val)) {
                    $val = utf8_decode($val);
                }
                $length = strlen($val);
            }
            $min_len = $field['min_length'] ?? 0;
            $max_len = $field['max_length'];
            $rel_val = $array[$field['relative_to']];

            if (empty($invalid_err)) {
                $invalid_err = sprintf("Invalid %s : '%s'", $title, $val);
            }
            if (is_array($array[$field['name']])) {
                $invalid_err = '';
            }

            //Checking if its required or not
            if ($req == 'yes') {
                if (empty($val) && !is_array($array[$field['name']])) {
                    e($invalid_err);
                    $block = true;
                } else {
                    $block = false;
                }
            } else {
                //if field not required and empty it's valid
                $funct_err = true;
            }
            if (!empty($val) || $val === '0') {
                //don't test validity if field is empty
                $funct_err = is_valid_value($field['validate_function'], $val);
            }
            if (!$block) {
                //Checking Syntax
                if (!$funct_err) {
                    if (!empty($function_error_msg)) {
                        e($function_error_msg);
                    } elseif (!empty($invalid_err)) {
                        e($invalid_err);
                    }
                }

                if (!is_valid_syntax($field['syntax_type'], $val)) {
                    if (!empty($invalid_err)) {
                        e($invalid_err);
                    }
                }
                if (isset($max_len)) {
                    if ($length > $max_len || $length < $min_len) {
                        e(lang('please_enter_val_bw_min_max', [$title, $min_len, $field['max_length']]));
                    }
                }
                if (function_exists($field['db_value_check_func'])) {
                    $db_val_result = $field['db_value_check_func']($val);
                    if ($db_val_result != $field['db_value_exists']) {
                        if (!empty($field['db_value_err'])) {
                            e($field['db_value_err']);
                        } elseif (!empty($invalid_err)) {
                            e($invalid_err);
                        }
                    }
                }
                if (isset($field['constraint_func']) && function_exists($field['constraint_func'])) {
                    if (!$field['constraint_func']($val)) {
                        e($field['constraint_err']);
                    }
                }
                if ($field['relative_type'] != '') {
                    switch ($field['relative_type']) {
                        case 'exact':
                            if ($rel_val != $val) {
                                if (!empty($field['relative_err'])) {
                                    e($field['relative_err']);
                                } elseif (!empty($invalid_err)) {
                                    e($invalid_err);
                                }
                            }
                            break;
                    }
                }
            }
        }
    }
}

/**
 * Function used to check time span a time difference function that outputs the
 * time passed in facebook's style: 1 day ago, or 4 months ago. I took andrew dot
 * macrobert at gmail dot com function and tweaked it a bit. On a strict enviroment
 * it was throwing errors, plus I needed it to calculate the difference in time between
 * a past date and a future date
 * thanks to yasmary at gmail dot com
 *
 * @param : { string } { $date } { date to be converted in nicetime }
 * @param bool $istime
 *
 * @return string
 * @throws Exception
 * @uses : { function : lang() }
 */
function nicetime($date, $istime = false): string
{
    if (empty($date)) {
        return lang('no_date_provided');
    }
    $period_sing = [lang('second'), lang('minute'), lang('hour'), lang('day'), lang('week'), lang('month'), lang('year'), lang('decade')];
    $period_plur = [lang('seconds'), lang('minutes'), lang('hours'), lang('days'), lang('weeks'), lang('months'), lang('years'), lang('decades')];
    $lengths = [60, 60, 24, 7, 4.35, 12, 10];
    $now = time();
    if (!$istime) {
        $unix_date = strtotime($date);
    } else {
        $unix_date = $date;
    }
    // check validity of date
    if (empty($unix_date) || $unix_date < 1) {
        return lang('bad_date');
    }
    // is it future date or past date
    if ($now > $unix_date) {
        //time_ago
        $difference = $now - $unix_date;
        $tense = 'time_ago';
    } else {
        //from_now
        $difference = $unix_date - $now;
        $tense = 'from_now';
    }
    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);

    $period = $difference > 1 ? $period_plur[$j] : $period_sing[$j];

    if ($difference > 1) {
        $period = $period_plur[$j];
    } else {
        $period = $period_sing[$j];
    }

    return lang($tense, [$difference, $period]);
}

/**
 * Function used to format outgoing link
 *
 * @param : { string } { $out } { link to some webpage }
 *
 * @return string : { string } { HTML anchor tag with link in place }
 * @throws Exception
 */
function outgoing_link($url): string
{
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return lang('incorrect_url');
    }

    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = 'http://' . $url;
    }

    return '<a href="' . display_clean($url) . '" target="_blank">' . display_clean($url) . '</a>';
}

/**
 * Function used to get country via country code
 *
 * @param : { string } { $code } { country code name }
 *
 * @return bool|string : { string } { country name of flag }
 * @throws Exception
 */
function get_country($code)
{
    $result = Clipbucket_db::getInstance()->select(tbl('countries'), 'name_en,iso2', " iso2='$code' OR iso3='$code'");
    if (count($result) > 0) {
        $result = $result[0];
        $flag = '<img src="/images/icons/country/' . strtolower($result['iso2']) . '.png" alt="" border="0">&nbsp;';
        return $flag . $result['name_en'];
    }
    return false;
}

/**
 * function used to get collections
 * @param $param
 *
 * @return array|bool
 * @throws Exception
 * @uses : { class : $cbcollection } { function : get_collections }
 */
function get_collections($param)
{
    global $cbcollection;
    return $cbcollection->get_collections($param);
}

/**
 * function used to get users
 * @param $param
 *
 * @return bool|mixed
 * @throws Exception
 * @uses : { class : $userquery } { function : get_users }
 */
function get_users($param)
{
    return userquery::getInstance()->get_users($param);
}

/**
 * Function used to call functions
 *
 * @param      $in
 * @param null $params
 *
 * @internal param $ : { array } { $in } { array with functions to be called } { $in } { array with functions to be called }
 * @internal param $ : { array } { $params } { array with parameters for functions } { $params } { array with parameters for functions }
 */
function call_functions($in, $params = null)
{
    if (is_array($in)) {
        foreach ($in as $i) {
            if (function_exists($i)) {
                if (!$params) {
                    $i();
                } else {
                    $i($params);
                }
            }
        }
    } else {
        if (function_exists($in)) {
            if (!$params) {
                $in();
            } else {
                $in($params);
            }
        }

    }
}

/**
 * Category Link is used to return category based link
 *
 * @param $data
 * @param $type
 *
 * @return string : { string } { sorting link }
 * @internal param $ : { array } { $data } { array with category details } { $data } { array with category details }
 * @internal param $ : { string } { $type } { type of category e.g videos } { $type } { type of category e.g videos }
 */
function category_link($data, $type): string
{
    $sort = '';
    $time = '';
    $seo_cat_name = '';

    if (SEO == 'yes') {
        if (isset($_GET['sort']) && $_GET['sort'] != '') {
            $sort = '/' . $_GET['sort'];
        }
        if (isset($_GET['time']) && $_GET['time'] != '') {
            $time = '/' . $_GET['time'];
        }
    } else {
        if (isset($_GET['sort']) && $_GET['sort'] != '') {
            $sort = '&sort=' . $_GET['sort'];
        }
        if (isset($_GET['time']) && $_GET['time'] != '') {
            $time = '&time=' . $_GET['time'];
        }
        if (isset($_GET['seo_cat_name']) && $_GET['seo_cat_name'] != '') {
            $time = '&seo_cat_name=' . $_GET['seo_cat_name'];
        }
    }

    switch ($type) {
        case 'video':
        case 'videos':
        case 'v':
            if (SEO == 'yes') {
                return '/videos/' . $data['category_id'] . '/' . SEO($data['category_name']) . $sort . $time . '/';
            }
            return '/videos.php?cat=' . $data['category_id'] . $sort . $time . $seo_cat_name;

        case 'channels':
        case 'channel':
        case 'c':
        case 'user':
            if (SEO == 'yes') {
                return '/channels/' . $data['category_id'] . '/' . SEO($data['category_name']) . $sort . $time . '/';
            }
            return '/channels.php?cat=' . $data['category_id'] . $sort . $time . $seo_cat_name;

        default:
            if (THIS_PAGE == 'photos') {
                $type = 'photos';
            }

            if (defined("IN_MODULE")) {
                global $prefix_catlink;
                $url = 'cat=' . $data['category_id'] . $sort . $time . '&page=' . $_GET['page'] . $seo_cat_name;
                $url = $prefix_catlink . $url;
                $rm_array = ['cat', 'sort', 'time', 'page', 'seo_cat_name'];
                if ($prefix_catlink) {
                    $rm_array[] = 'p';
                }
                $plugURL = queryString($url, $rm_array);
                return $plugURL;
            }

            if (SEO == 'yes') {
                return '/' . $type . '/' . $data['category_id'] . '/' . SEO($data['category_name']) . $sort . $time . '/';
            }
            return '/' . $type . '.php?cat=' . $data['category_id'] . $sort . $time . $seo_cat_name;
    }
}

/**
 * Sorting Links is used to return Sorting based link
 *
 * @param        $sort
 * @param string $mode
 * @param        $type
 *
 * @return string : { string } { sorting link }
 * @internal param $ : { string } { $sort } { specifies sorting style } { $sort } { specifies sorting style }
 * @internal param $ : { string } { $mode } { element to sort e.g time } { $mode } { element to sort e.g time }
 * @internal param $ : { string } { $type } { type of element to sort e.g channels } { $type } { type of element to sort e.g channels }
 */
function sort_link($sort, $mode, $type): string
{
    switch ($type) {
        case 'video':
        case 'videos':
        case 'v':
            if (!isset($_GET['cat'])) {
                $_GET['cat'] = 'all';
            }
            if (!isset($_GET['time'])) {
                $_GET['time'] = 'all_time';
            }
            if (!isset($_GET['sort'])) {
                $_GET['sort'] = 'most_recent';
            }
            if (!isset($_GET['page'])) {
                $_GET['page'] = 1;
            }
            if (!isset($_GET['seo_cat_name'])) {
                $_GET['seo_cat_name'] = 'All';
            }

            $_GET['page'] = 1;
            if ($mode == 'sort') {
                $sorting = $sort;
            } else {
                $sorting = $_GET['sort'];
            }
            if ($mode == 'time') {
                $time = $sort;
            } else {
                $time = $_GET['time'];
            }

            if (SEO == 'yes') {
                return '/videos/' . $_GET['cat'] . '/' . $_GET['seo_cat_name'] . '/' . $sorting . '/' . $time . '/' . $_GET['page'];
            }
            return '/videos.php?cat=' . $_GET['cat'] . '&sort=' . $sorting . '&time=' . $time . '&page=' . $_GET['page'] . '&seo_cat_name=' . $_GET['seo_cat_name'];

        case 'channels':
        case 'channel':
            if (!isset($_GET['cat'])) {
                $_GET['cat'] = 'all';
            }
            if (!isset($_GET['time'])) {
                $_GET['time'] = 'all_time';
            }
            if (!isset($_GET['sort'])) {
                $_GET['sort'] = 'most_recent';
            }
            if (!isset($_GET['page'])) {
                $_GET['page'] = 1;
            }
            if (!isset($_GET['seo_cat_name'])) {
                $_GET['seo_cat_name'] = 'All';
            }

            if ($mode == 'sort') {
                $sorting = $sort;
            } else {
                $sorting = $_GET['sort'];
            }
            if ($mode == 'time') {
                $time = $sort;
            } else {
                $time = $_GET['time'];
            }

            if (SEO == 'yes') {
                return '/channels/' . $_GET['cat'] . '/' . $_GET['seo_cat_name'] . '/' . $sorting . '/' . $time . '/' . $_GET['page'];
            }
            return '/channels.php?cat=' . $_GET['cat'] . '&sort=' . $sorting . '&time=' . $time . '&page=' . $_GET['page'] . '&seo_cat_name=' . $_GET['seo_cat_name'];


        default:
            if (!isset($_GET['cat'])) {
                $_GET['cat'] = 'all';
            }
            if (!isset($_GET['time'])) {
                $_GET['time'] = 'all_time';
            }
            if (!isset($_GET['sort'])) {
                $_GET['sort'] = 'most_recent';
            }
            if (!isset($_GET['page'])) {
                $_GET['page'] = 1;
            }
            if (!isset($_GET['seo_cat_name'])) {
                $_GET['seo_cat_name'] = 'All';
            }

            if ($mode == 'sort') {
                $sorting = $sort;
            } else {
                $sorting = $_GET['sort'];
            }
            if ($mode == 'time') {
                $time = $sort;
            } else {
                $time = $_GET['time'];
            }

            if (THIS_PAGE == 'photos') {
                $type = 'photos';
            }

            if (defined("IN_MODULE")) {
                $url = 'cat=' . $_GET['cat'] . '&sort=' . $sorting . '&time=' . $time . '&page=' . $_GET['page'] . '&seo_cat_name=' . $_GET['seo_cat_name'];
                $plugURL = queryString($url, ["cat", "sort", "time", "page", "seo_cat_name"]);
                return $plugURL;
            }

            if (SEO == 'yes') {
                return '/' . $type . '/' . $_GET['cat'] . '/' . $_GET['seo_cat_name'] . '/' . $sorting . '/' . $time . '/' . $_GET['page'];
            }
            return '/' . $type . '.php?cat=' . $_GET['cat'] . '&sort=' . $sorting . '&time=' . $time . '&page=' . $_GET['page'] . '&seo_cat_name=' . $_GET['seo_cat_name'];
    }
}

/**
 * Function used to get flag options
 * @uses : { class : $action } { var : $report_opts }
 */
function get_flag_options()
{
    $action = new cbactions();
    $action->init();
    return $action->report_opts;
}

/**
 * Function used to display flag type
 * @param $id
 *
 * @return
 * @uses : { get_flag_options() function }
 *
 */
function flag_type($id)
{
    $flag_opts = get_flag_options();
    return $flag_opts[$id];
}

/**
 * Function used to load captcha field
 * @uses : { class : $Cbucket }  { var : $captchas }
 */
function get_captcha()
{
    global $Cbucket;
    if (count($Cbucket->captchas) > 0) {
        return $Cbucket->captchas[0];
    }
    return false;
}

/**
 * Function used to load captcha
 * @param : { array } { $params } { an array of parametrs }
 */
define('GLOBAL_CB_CAPTCHA', 'cb_captcha');
function load_captcha($params)
{
    global $total_captchas_loaded;
    switch ($params['load']) {
        case 'function':
            if ($total_captchas_loaded != 0) {
                $total_captchas_loaded = $total_captchas_loaded + 1;
            } else {
                $total_captchas_loaded = 1;
            }
            $_SESSION['total_captchas_loaded'] = $total_captchas_loaded;
            if (function_exists($params['captcha']['load_function'])) {
                return $params['captcha']['load_function']() . '<input name="cb_captcha_enabled" type="hidden" id="cb_captcha_enabled" value="yes" />';
            }
            break;

        case 'field':
            echo '<input type="text" ' . $params['field_params'] . ' name="' . GLOBAL_CB_CAPTCHA . '" />';
            break;
    }
}

/**
 * Function used to verify captcha
 */
function verify_captcha()
{
    $var = post('cb_captcha_enabled');
    if ($var == 'yes') {
        $captcha = get_captcha();
        $val = $captcha['validate_function'](post(GLOBAL_CB_CAPTCHA));
        return $val;
    }
    return true;
}

/**
 * Adds title for ClipBucket powered website
 *
 * @param bool $params
 *
 * @internal param $ : { string } { $title } { title to be given to page } { $title } { title to be given to page }
 */
function cbtitle($params = false)
{
    global $cbsubtitle;
    $sub_sep = getArrayValue($params, 'sub_sep');
    if (!$sub_sep) {
        $sub_sep = '-';
    }
    //Getting Subtitle
    if (!$cbsubtitle) {
        echo display_clean(TITLE . ' - ' . SLOGAN);
    } else {
        echo display_clean($cbsubtitle . ' ' . $sub_sep . ' ' . TITLE);
    }
}

/**
 * Adds subtitle for any given page
 * @param : { string } { $title } { title to be given to page }
 */
function subtitle($title)
{
    global $cbsubtitle;
    $cbsubtitle = $title;
}

/**
 * Extract user's name using userid
 * @param $uid
 *
 * @return
 * @uses : { class : $userquery } { function : get_username }
 *
 */
function get_username($uid)
{
    return userquery::getInstance()->get_username($uid);
}

/**
 * Extract collection's name using Collection's id
 * function is mostly used via Smarty template engine
 *
 * @param        $cid
 * @param string $field
 *
 * @return bool
 * @throws Exception
 * @uses : { class : $cbcollection } { function : get_collection_field }
 */
function get_collection_field($cid, $field = 'collection_name')
{
    global $cbcollection;
    return $cbcollection->get_collection_field($cid, $field);
}

/**
 * Get ClipBucket's footer menu
 * @param null $params
 *
 * @return array
 * @throws Exception
 * @uses : { class : $Cbucket } { function : foot_menu }
 */
function foot_menu($params = null)
{
    return Clipbucket::getInstance()->foot_menu($params);
}

/**
 * Converts given array XML into a PHP array
 *
 * @param : { array } { $array } { array to be converted into XML }
 * @param int $get_attributes
 * @param string $priority
 * @param bool $is_url
 *
 * @return array|bool : { string } { $xml } { array converted into XML }
 */
function xml2array($url, $get_attributes = 1, $priority = 'tag', $is_url = true)
{
    $contents = "";

    if ($is_url) {
        $fp = @ fopen($url, 'rb');
        if ($fp) {
            while (!feof($fp)) {
                $contents .= fread($fp, 8192);
            }
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2) Gecko/20070219 Firefox/3.0.0.2');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 600);
            $contents = curl_exec($ch);
            curl_close($ch);
        }
        fclose($fp);

        if (!$contents) {
            return false;
        }
    } else {
        $contents = $url;
    }

    if (!function_exists('xml_parser_create')) {
        return false;
    }
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values) {
        return false;
    }
    $xml_array = [];

    $current = &$xml_array;
    $repeated_tag_index = [];
    foreach ($xml_values as $data) {
        unset ($attributes, $value);
        extract($data);
        $result = [];
        $attributes_data = [];
        if (isset ($value)) {
            if ($priority == 'tag') {
                $result = $value;
            } else {
                $result['value'] = $value;
            }
        }
        if (isset ($attributes) and $get_attributes) {
            foreach ($attributes as $attr => $val) {
                if ($priority == 'tag') {
                    $attributes_data[$attr] = $val;
                } else {
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                }
            }
        }
        if ($type == "open") {
            $parent[$level - 1] = &$current;
            if (!is_array($current) or (!in_array($tag, array_keys($current)))) {
                $current[$tag] = $result;
                if ($attributes_data) {
                    $current[$tag . '_attr'] = $attributes_data;
                }
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = &$current[$tag];
            } else {
                if (isset ($current[$tag][0])) {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {
                    $current[$tag] = [
                        $current[$tag],
                        $result
                    ];
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr'])) {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = &$current[$tag][$last_item_index];
            }
        } elseif ($type == "complete") {
            if (!isset ($current[$tag])) {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data) {
                    $current[$tag . '_attr'] = $attributes_data;
                }
            } else {
                if (isset ($current[$tag][0]) and is_array($current[$tag])) {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {
                    $current[$tag] = [
                        $current[$tag],
                        $result
                    ];
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes) {
                        if (isset ($current[$tag . '_attr'])) {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        } elseif ($type == 'close') {
            $current = &$parent[$level - 1];
        }
    }
    return ($xml_array);
}

/**
 * Converts given array into valid XML
 *
 * @param : { array } { $array } { array to be converted into XML }
 * @param int $level
 *
 * @return string : { string } { $xml } { array converted into XML }
 */
function array2xml($array, $level = 1)
{
    $xml = '';
    foreach ($array as $key => $value) {
        $key = strtolower($key);
        if (is_object($value)) // convert object to array
        {
            $value = get_object_vars($value);
        }

        if (is_array($value)) {
            $multi_tags = false;
            foreach ($value as $key2 => $value2) {
                if (is_object($value2)) // convert object to array
                {
                    $value2 = get_object_vars($value2);
                }
                if (is_array($value2)) {
                    $xml .= str_repeat("\t", $level) . "<$key>\n";
                    $xml .= array2xml($value2, $level + 1);
                    $xml .= str_repeat("\t", $level) . "</$key>\n";
                    $multi_tags = true;
                } else {
                    if (trim($value2) != '') {
                        if (htmlspecialchars($value2) != $value2) {
                            $xml .= str_repeat("\t", $level) .
                                "<$key2><![CDATA[$value2]]>" . // changed $key to $key2... didn't work otherwise.
                                "</$key2>\n";
                        } else {
                            $xml .= str_repeat("\t", $level) .
                                "<$key2>$value2</$key2>\n"; // changed $key to $key2
                        }
                    }
                    $multi_tags = true;
                }
            }
            if (!$multi_tags and count($value) > 0) {
                $xml .= str_repeat("\t", $level) . "<$key>\n";
                $xml .= array2xml($value, $level + 1);
                $xml .= str_repeat("\t", $level) . "</$key>\n";
            }

        } else {
            if (trim($value) != '') {
                echo "value=$value<br>";
                if (htmlspecialchars($value) != $value) {
                    $xml .= str_repeat("\t", $level) . "<$key>" .
                        "<![CDATA[$value]]></$key>\n";
                } else {
                    $xml .= str_repeat("\t", $level) .
                        "<$key>$value</$key>\n";
                }
            }
        }
    }
    return $xml;
}

/**
 * This function used to include headers in <head> tag
 * it will check weather to include the file or not
 * it will take file and its type as an array
 * then compare its type with THIS_PAGE constant
 * if header has TYPE of THIS_PAGE then it will be inlucded
 *
 * @param : { array } { $params } { parameters array e.g file, type }
 *
 * @return bool : { false }
 * @throws Exception
 */
function include_header($params)
{
    $file = getArrayValue($params, 'file');
    $type = getArrayValue($params, 'type');
    if ($file == 'global_header') {
        Template(DirPath::get('styles') . 'global/head.html', false);
        return false;
    }
    if (!$type) {
        $type = 'global';
    }
    if (is_includeable($type)) {
        Template($file, false);
    }
    return false;
}

/**
 * Function used to check weather to include given file or not
 * it will take array of pages if array has ACTIVE PAGE or has GLOBAL value
 * it will return true otherwise FALSE
 *
 * @param : { array } { $array } { array with files to include }
 *
 * @return bool : { boolean } { true or false depending on situation }
 */
function is_includeable($array)
{
    if (!is_array($array)) {
        $array = [$array];
    }
    if (in_array(THIS_PAGE, $array) || in_array('global', $array)) {
        return true;
    }
    return false;
}

/**
 * This function works the same way as include_header
 * but the only difference is , it is used to include
 * JS files only
 *
 * @param : { array } { $params } { array with parameters e.g  file, type}
 * @return : { string } { javascript tag with file in src }
 */
$the_js_files = [];
function include_js($params)
{
    global $the_js_files;
    $file = $params['file'];
    $type = $params['type'];
    if (!in_array($file, $the_js_files)) {
        $the_js_files[] = $file;

        if (is_array($type)) {
            foreach ($type as $t) {
                if ($t == THIS_PAGE) {
                    return '<script src="' . DirPath::getUrl('js') . $file . '" type="text/javascript"></script>';
                }
            }
        }

        switch ($type) {
            default:
            case 'global:':
                $url = DirPath::getUrl('js');
                break;
            case 'plugin':
                $url = DirPath::getUrl('plugins');
                break;
            case 'player':
                $url = DirPath::getUrl('player');
                break;
            case 'vendor':
                $url = DirPath::getUrl('vendor');
                break;
            case 'admin':
                $url = TEMPLATEURL . '/theme/js/';
                break;
        }
        return '<script src="' . $url . $file . '" type="text/javascript"></script>';
    }
    return false;
}

$the_css_files = [];
function include_css($params)
{
    global $the_css_files;
    $file = $params['file'];
    $type = $params['type'];
    if (!in_array($file, $the_css_files)) {
        $the_css_files[] = $file;

        if (is_array($type)) {
            foreach ($type as $t) {
                if ($t == THIS_PAGE) {
                    error_log(DirPath::getUrl('css') . $file);
                    return '<link rel="stylesheet" href="' . DirPath::getUrl('css') . $file . '" ">';
                }
            }
        }

        switch ($type) {
            default:
            case 'global:':
                $url = DirPath::getUrl('css');
                break;
            case 'plugin':
                $url = DirPath::getUrl('plugins');
                break;
            case 'player':
                $url = DirPath::getUrl('player');
                break;
            case 'admin':
                $url = TEMPLATEURL . '/theme/css/';
                break;
            case 'vendor':
                $url = DirPath::getUrl('vendor');
                break;
            case 'custom':
                $url = DirPath::getUrl('files');
                break;
        }
        return '<link rel="stylesheet" href="' . $url . $file . '">';
    }
    return false;
}

function get_ffmpeg_codecs($type)
{
    switch ($type) {
        case 'audio':
            $codecs = [
                'aac',
                'aac_latm',
                'libfaac',
                'libvo_aacenc',
                'libxvid',
                'libmp3lame'
            ];
            break;

        case 'video':
        default:
            $codecs = [
                'libx264',
                'libtheora'
            ];
            break;
    }

    $codec_installed = [];
    foreach ($codecs as $codec) {
        $get_codec = System::shell_output(System::get_binaries('ffmpeg') . ' -codecs 2>/dev/null | grep "' . $codec . '"');
        if ($get_codec) {
            $codec_installed[] = $codec;
        }
    }

    return $codec_installed;
}

/**
 * Calls ClipBucket footer into the battlefield
 */
function footer()
{
    $funcs = get_functions('clipbucket_footer');
    if (is_array($funcs) && count($funcs) > 0) {
        foreach ($funcs as $func) {
            if (function_exists($func)) {
                $func();
            }
        }
    }
}

/**
 * Function used to generate RSS FEED links
 *
 * @param : { array } { $params } { array with parameters }
 *
 * @return mixed
 */
function rss_feeds($params)
{
    if( config('enable_rss_feeds') == 'no'){
        return false;
    }
    /**
     * setting up the feeds arrays..
     * if you want to call em in your functions..simply call the global variable $rss_feeds
     */
    $rss_link = cblink(["name" => "rss"]);
    $rss_feeds = [];
    $rss_feeds[] = ["title" => "Recently added videos", "link" => $rss_link . "recent"];
    $rss_feeds[] = ["title" => "Most Viewed Videos", "link" => $rss_link . "views"];
    $rss_feeds[] = ["title" => "Top Rated Videos", "link" => $rss_link . "rating"];
    $rss_feeds[] = ["title" => "Videos Being Watched", "link" => $rss_link . "watching"];

    $funcs = get_functions('rss_feeds');
    if (is_array($funcs)) {
        foreach ($funcs as $func) {
            return $func($params);
        }
    }

    if ($params['link_tag']) {
        foreach ($rss_feeds as $rss_feed) {
            echo "<link rel=\"alternate\" type=\"application/rss+xml\"
				title=\"" . $rss_feed['title'] . "\" href=\"" . $rss_feed['link'] . "\" />\n";
        }
    }
}

/**
 * Function used to insert Log
 * @param $type
 * @param $details
 * @throws Exception
 * @uses { class : $cblog } { function : insert }
 */
function insert_log($type, $details)
{
    global $cblog;
    $cblog->insert($type, $details);
}

/**
 * Function used to get database size
 * @return int : { $dbsize }
 * @throws Exception
 */
function get_db_size(): int
{
    $results = Clipbucket_db::getInstance()->_select('SHOW TABLE STATUS');
    $dbsize = 0;
    foreach ($results as $row) {
        $dbsize += $row['Data_length'] + $row['Index_length'];
    }
    return $dbsize;
}

/**
 * Function used to check weather user has marked comment as spam or not
 *
 * @param : { array } { $comment } { array with all details of comment }
 *
 * @return bool : { boolean } { true if marked as spam, else false }
 */
function marked_spammed($comment): bool
{
    $spam_voters = explode("|", $comment['spam_voters']);
    $admin_vote = in_array('1', $spam_voters);
    if (user_id() && in_array(user_id(), $spam_voters)) {
        return true;
    }

    if ($admin_vote) {
        return true;
    }
    return false;
}

/**
 * Check installation of ClipBucket
 *
 * @param : { string } { $type } { type of check e.g before, after }
 *
 * @return bool|void
 */
function check_install($type)
{
    if (in_dev()) {
        return true;
    }

    global $Cbucket;
    switch ($type) {
        case 'before':
            if (!file_exists('includes/config.php') && file_exists('files/temp/install.me') && !file_exists('files/temp/install.me.not')) {
                header('Location: ' . get_server_url() . '/cb_install');
                die();
            }
            break;

        case 'after':
            if (file_exists('files/temp/install.me') && !file_exists('files/temp/install.me.not')) {
                $Cbucket->configs['closed'] = 1;
            }
            break;
    }
}

/**
 * Function to get server URL
 * @return string { string } { url of server }
 * @internal param $ : { none }
 */
function get_server_url(): string
{
    $DirName = dirname($_SERVER['PHP_SELF']);
    if (preg_match('/admin_area/i', $DirName)) {
        $DirName = str_replace('/admin_area', '', $DirName);
    }

    if (preg_match('/cb_install/i', $DirName)) {
        $DirName = str_replace('/cb_install', '', $DirName);
    }
    return get_server_protocol() . $_SERVER['HTTP_HOST'] . $DirName;
}

/**
 * Get current protocol of server that CB is running on
 * @return mixed|string { string } { $protocol } { http or https }
 */
function get_server_protocol()
{
    if (is_ssl()) {
        return 'https://';
    }

    $protocol = preg_replace('/^([a-z]+)\/.*$/', '\\1', strtolower($_SERVER['SERVER_PROTOCOL']));
    $protocol .= '://';
    return $protocol;
}

/**
 * Returns <kbd>true</kbd> if the string or array of string is encoded in UTF8.
 *
 * Example of use. If you want to know if a file is saved in UTF8 format :
 * <code> $array = file('one file.txt');
 * $isUTF8 = isUTF8($array);
 * if (!$isUTF8) --> we need to apply utf8_encode() to be in UTF8
 * else --> we are in UTF8 :)
 * </code>
 * @param mixed A string, or an array from a file() function.
 * @return boolean
 */
function isUTF8($string): bool
{
    if (is_array($string)) {
        $enc = implode('', $string);
        return @!((ord($enc[0]) != 239) && (ord($enc[1]) != 187) && (ord($enc[2]) != 191));
    }
    return (utf8_encode(utf8_decode($string)) == $string);
}

/**
 * Generate embed code of provided video
 *
 * @param : { array } { $vdetails } { all details of video }
 *
 * @return string : { string } { $code } { embed code for video }
 */
function embeded_code($vdetails): string
{
    $code = '<object width="' . EMBED_VDO_WIDTH . '" height="' . EMBED_VDO_HEIGHT . '">';
    $code .= '<param name="allowFullScreen" value="true">';
    $code .= '</param><param name="allowscriptaccess" value="always"></param>';
    //Replacing Height And Width
    $h_w_p = ["{Width}", "{Height}"];
    $h_w_r = [EMBED_VDO_WIDTH, EMBED_VDO_HEIGHT];
    $embed_code = str_replace($h_w_p, $h_w_r, $vdetails['embed_code']);
    $code .= unhtmlentities($embed_code);
    $code .= '</object>';
    return $code;
}

/**
 * function used to convert input to proper date created format
 *
 * @param : { string } { date in string }
 *
 * @return string : { string } { proper date format }
 */
function datecreated($in): string
{
    if (!empty($in)) {
        $datecreated = DateTime::createFromFormat(DATE_FORMAT, $in);
        if ($datecreated) {
            return $datecreated->format('Y-m-d');
        }
        return $in;
    }
    return '2000-01-01';
}

/**
 * Check if website is using SSL or not
 * @return bool { boolean } { true if SSL, else false }
 * @internal param $ { none }
 * @since 2.6.0
 */
function is_ssl(): bool
{
    if (isset($_SERVER['HTTPS'])) {
        if ('on' == strtolower($_SERVER['HTTPS'])) {
            return true;
        }
        if ('1' == $_SERVER['HTTPS']) {
            return true;
        }
    }
    if (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
        return true;
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        return true;
    }
    return false;
}

/**
 * This will update stats like Favorite count, Playlist count
 *
 * @param string $type
 * @param string $object
 * @param $id
 * @param string $op
 *
 * @throws Exception
 * @action : database updation
 */
function updateObjectStats($type, $object, $id, $op = '+')
{
    switch ($type) {
        case "favorite":
        case "favourite":
        case "favorites":
        case "favourties":
        case "fav":
            switch ($object) {
                case "video":
                case "videos":
                case "v":
                    Clipbucket_db::getInstance()->update(tbl('video'), ['favourite_count'], ["|f|favourite_count" . $op . "1"], " videoid = '" . $id . "'");
                    break;

                case "photo":
                case "photos":
                case "p":
                    Clipbucket_db::getInstance()->update(tbl('photos'), ['total_favorites'], ["|f|total_favorites" . $op . "1"], " photo_id = '" . $id . "'");
                    break;
            }
            break;

        case "playlist":
        case "playList":
        case "plist":
            switch ($object) {
                case "video":
                case "videos":
                case "v":
                    Clipbucket_db::getInstance()->update(tbl('video'), ['playlist_count'], ["|f|playlist_count" . $op . "1"], " videoid = '" . $id . "'");
                    break;
            }
            break;
    }
}

/**
 * Function used to check weather conversion lock exists or not
 * if conversion log exists it means no further conersion commands will be executed
 * @return bool { boolean } { true if conversion lock exists, else false }
 * { true if conversion lock exists, else false }
 */
function conv_lock_exists(): bool
{
    for ($i = 0; $i < config('max_conversion'); $i++) {
        if (file_exists(DirPath::get('temp') . 'conv_lock' . $i . '.loc')) {
            return true;
        }
    }

    return false;
}

/**
 * Function used to return a well-formed queryString
 * for passing variables to url
 * @input variable_name
 *
 * @param bool $var
 * @param bool $remove
 *
 * @return string
 */
function queryString($var = false, $remove = false)
{
    $queryString = $_SERVER['QUERY_STRING'];
    if ($var) {
        $queryString = preg_replace("/&?$var=([\w+\s\b\.?\S]+|)/", "", $queryString);
    }

    if ($remove) {
        if (!is_array($remove)) {
            $queryString = preg_replace("/&?$remove=([\w+\s\b\.?\S]+|)/", "", $queryString);
        } else {
            foreach ($remove as $rm) {
                $queryString = preg_replace("/&?$rm=([\w+\s\b\.?\S]+|)/", "", $queryString);
            }
        }
    }

    if ($queryString) {
        $preUrl = "?$queryString&";
    } else {
        $preUrl = "?";
    }
    $preUrl = preg_replace(["/(\&{2,10})/", "/\?\&/"], ["&", "?"], $preUrl);
    return $preUrl . $var;
}

/**
 * Checks if CURL is installed on server
 * @return bool : { boolean } { true if curl found, else false }
 * @internal param $ : { none }
 */
function isCurlInstalled(): bool
{
    if (in_array('curl', get_loaded_extensions())) {
        return true;
    }
    return false;
}

/**
 * Load configuration related files for uploader (video, photo)
 */
function uploaderDetails()
{
    $uploaderDetails = [
        'uploadScriptPath' => '/actions/file_uploader.php',
    ];

    $photoUploaderDetails = [
        'uploadScriptPath' => '/actions/photo_uploader.php',
    ];

    assign('uploaderDetails', $uploaderDetails);
    assign('photoUploaderDetails', $photoUploaderDetails);
    //Calling Custom Functions
    cb_call_functions('uploaderDetails');
}

/**
 * Checks if given section is enabled or not e.g videos, photos
 *
 * @param : { string } { $input } { section to check }
 * @return bool|void
 */
function isSectionEnabled($input)
{
    $section = config($input . 'Section');

    if ($section == 'yes' || (defined('THIS_PAGE') && THIS_PAGE == 'cb_install') ) {
        return true;
    }
    return false;
}

/**
 * Updates last commented data - helps cache refresh
 * @param $type
 * @param $id
 * @throws Exception
 * @action : database updation
 */
function update_last_commented($type, $id)
{
    if ($type && $id) {
        switch ($type) {
            case "v":
            case "video":
            case "vdo":
            case "vid":
            case "videos":
                Clipbucket_db::getInstance()->update(tbl("video"), ['last_commented'], [now()], "videoid='$id'");
                break;

            case "c":
            case "channel":
            case "user":
            case "u":
            case "users":
            case "channels":
                Clipbucket_db::getInstance()->update(tbl("users"), ['last_commented'], [now()], "userid='$id'");
                break;

            case "cl":
            case "collection":
            case "collect":
            case "collections":
            case "collects":
                Clipbucket_db::getInstance()->update(tbl("collections"), ['last_commented'], [now()], "collection_id='$id'");
                break;

            case "p":
            case "photo":
            case "photos":
            case "picture":
            case "pictures":
                Clipbucket_db::getInstance()->update(tbl("photos"), ['last_commented'], [now()], "photo_id='$id'");
                break;
        }
    }
}

/**
 * Inserts new feed against given user
 *
 * @param : { array } { $array } { array with all details of feed e.g userid, action etc }
 * @action : inserts feed into database
 */
function addFeed($array)
{
    global $cbfeeds;
    $action = $array['action'];
    if ($array['uid']) {
        $userid = $array['uid'];
    } else {
        $userid = user_id();
    }

    switch ($action) {
        default:
            return;

        case "upload_photo":
            $feed['object'] = 'photo';
            break;

        case "add_comment":
            $feed['object'] = $array['object'];
            break;

        case "upload_video":
        case "add_favorite":
            $feed['object'] = 'video';
            break;

        case "signup":
            $feed['object'] = 'signup';
            break;

        case "add_friend":
            $feed['object'] = 'friend';
            break;

        case "add_collection":
            $feed['object'] = 'collection';
            break;
    }
    $feed['uid'] = $userid;
    $feed['object_id'] = $array['object_id'];
    $feed['action'] = $action;
    $cbfeeds->addFeed($feed);
}

/**
 * Fetch directory of a plugin to make it dynamic
 *
 * @param : { string } { $pluginFile } { false by default, main file of plugin }
 *
 * @return string :    { string } { basename($pluginFile) } { directory path of plugin }
 */
function this_plugin($pluginFile = null)
{
    if (!$pluginFile) {
        global $pluginFile;
    }
    return basename(dirname($pluginFile));
}

/**
 * Fetch browser details for current user
 *
 * @param : { string } { $in } { false by default, HTTP_USER_AGENT }
 * @param bool $assign
 *
 * @return array : { array } { $array } { array with all details of user }
 */
function get_browser_details($in = null, $assign = false)
{
    //Checking if browser is firefox
    if (!$in) {
        $in = $_SERVER['HTTP_USER_AGENT'];
    }
    $u_agent = $in;
    $bname = 'Unknown';
    $platform = 'Unknown';

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/iPhone/i', $u_agent)) {
        $platform = 'iphone';
    } elseif (preg_match('/iPad/i', $u_agent)) {
        $platform = 'ipad';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Googlebot/i', $u_agent)) {
        $bname = 'Googlebot';
        $ub = "bot";
    } elseif (preg_match('/msnbot/i', $u_agent)) {
        $bname = 'MSNBot';
        $ub = "bot";
    } elseif (preg_match('/Yahoo\! Slurp/i', $u_agent)) {
        $bname = 'Yahoo Slurp';
        $ub = "bot";
    }

    // finally get the correct version number
    $known = ['Version', $ub, 'other'];
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!@preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    $array = [
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'bname'     => strtolower($ub),
        'pattern'   => $pattern
    ];

    if ($assign) {
        assign($assign, $array);
    } else {
        return $array;
    }
}

/**
 * @throws Exception
 */
function update_user_voted($array, $userid = null)
{
    userquery::getInstance()->update_user_voted($array, $userid);
}

/**
 * Deletes a video from a video collection
 * @param : { array } { $vdetails } { video details of video to be deleted }
 * @action : { calls function from video class }
 */
function delete_video_from_collection($vdetails)
{
    global $cbvid;
    $cbvid->collection->deleteItemFromCollections($vdetails['videoid']);
}

/**
 * Check if a remote file exists or not via curl without downloading it
 *
 * @param : { string } { $url } { URL of file to check }
 *
 * @return bool : { boolean } { true if file exists, else false }
 */
function checkRemoteFile($url): bool
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    if ($result !== false) {
        return true;
    }
    return false;
}

/**
 * function used to verify user age
 *
 * @param : { string } { $dob } { date of birth of user }\
 *
 * @return bool : { boolean } { true / false depending on situation }
 */
function verify_age($dob): bool
{
    $allowed_age = config('min_age_reg');
    if (empty($allowed_age) || $allowed_age < 1) {
        return true;
    }
    $age_time = strtotime($dob);
    $diff = time() - $age_time;
    $diff = $diff / 60 / 60 / 24 / 364;
    if ($diff >= $allowed_age) {
        return true;
    }
    return false;
}

/**
 * Checks development mode
 *
 * @return Boolean
 */
function in_dev(): bool
{
    if (defined('DEVELOPMENT_MODE')) {
        return DEVELOPMENT_MODE;
    }
    return false;
}

/**
 * Dumps data in pretty format [ latest CB prefers pr() instead ]
 *
 * @param array $data
 * @param bool $die
 */
function dump($data = [], $die = false)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    if ($die) {
        die();
    }
}

function debug_backtrace_string(): string
{
    $stack = '';
    $i = 1;
    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    unset($trace[0]); //Remove call to this function from stack trace
    foreach ($trace as $node) {
        $stack .= '#' . $i . ' ' . $node['file'] . '(' . $node['line'] . '): ';
        if (isset($node['class'])) {
            $stack .= $node['class'] . '->';
        }
        $stack .= $node['function'] . '()' . PHP_EOL;
        $i++;
    }
    return $stack;
}

/**
 * Displays a code error in developer friendly way [ used with PHP exceptions ]
 *
 * @param { Object } { $e } { complete current object }
 */
function show_cb_error($e)
{
    echo $e->getMessage();
    echo '<br>';
    echo 'On Line Number ';
    echo $e->getLine();
    echo '<br>';
    echo 'In file ';
    echo $e->getFile();
}

/**
 * Returns current page name or boolean for the given string
 *
 * @param string $name
 *
 * @return bool|string : { string / boolean } { page name if found, else false }
 * @internal param $ { string } { $name } { name of page to check against } { $name } { name of page to check against }
 */
function this_page($name = '')
{
    if (defined('THIS_PAGE')) {
        $page = THIS_PAGE;
        if ($name) {
            if ($page == $name) {
                return true;
            }
            return false;
        }
        return $page;
    }
    return false;
}

/**
 * Returns current page's parent name or boolean for the given string
 *
 * @param string $name
 *
 * @return bool|mixed|string : { string / boolean } { page name if found, else false }
 * @internal param $ { string } { $name } { name of page to check against } { $name } { name of page to check against }
 */
function parent_page($name = '')
{
    if (defined('PARENT_PAGE')) {
        $page = PARENT_PAGE;
        if ($name) {
            if ($page == $name) {
                return true;
            }
            return false;
        }
        return $page;
    }
    return false;
}

/**
 * Function used for building time links that are used
 * on main pages such as videos.php, photos.php etc
 * @return array : { array } { $array } { an array with all possible time sorts }
 * @throws Exception
 * @internal param $ : { none }
 */
function time_links(): array
{
    return [
        'all_time'   => lang('alltime'),
        'today'      => lang('today'),
        'yesterday'  => lang('yesterday'),
        'this_week'  => lang('thisweek'),
        'last_week'  => lang('lastweek'),
        'this_month' => lang('thismonth'),
        'last_month' => lang('lastmonth'),
        'this_year'  => lang('thisyear'),
        'last_year'  => lang('lastyear')
    ];
}

/*assign results to template for load more buttons on all_videos.html*/
function template_assign($results, $limit, $total_results, $template_path, $assigned_variable_smarty)
{
    if ($limit < $total_results) {
        $html = "";
        $count = $limit;
        foreach ($results as $key => $result) {
            assign("$assigned_variable_smarty", $result);
            $html .= Fetch($template_path);
        }
        $arr = ["template" => $html, 'count' => $count, 'total' => $limit];
    } else {
        $arr = 'limit_exceeds';
    }
    return $arr;
}

/**
 * function uses to parse certain string from bulk string
 * @param $needle_start
 * @param $needle_end
 * @param $results
 *
 * @return array|bool {bool/string/int} {true/$return_arr}
 * {true/$return_arr}
 * @author : Awais Tariq
 *
 * @internal param $ : {string} {$needle_start} { string from where the parse starts} {$needle_start} { string from where the parse starts}
 * @internal param $ : {string} {$needle_end} { string from where the parse end} {$needle_end} { string from where the parse end}
 * @internal param $ : {string} {$results} { total string in which we search} {$results} { total string in which we search}
 */
function find_string($needle_start, $needle_end, $results)
{
    if (empty($results) || empty($needle_start) || empty($needle_end)) {
        return false;
    }
    $start = strpos($results, $needle_start);
    $end = strpos($results, $needle_end);
    if (!empty($start) && !empty($end)) {
        $results = substr($results, $start, $end);
        $end = strpos($results, $needle_end);
        if (empty($end)) {
            return false;
        }
        $results = substr($results, 0, $end);
        return explode(':', $results);
    }
    return false;
}

/**
 * @throws Exception
 */
function fetch_action_logs($params)
{
    $cond = [];
    if ($params['type']) {
        $type = $params['type'];
        $cond['action_type'] = $type;
    }

    if ($params['user']) {
        $user = $params['user'];
        if (is_numeric($user)) {
            $cond['action_userid'] = $user;
        } else {
            $cond['action_username'] = $user;
        }
    }

    if ($params['umail']) {
        $mail = $params['umail'];
        $cond['action_usermail'] = $mail;
    }

    if ($params['ulevel']) {
        $level = $params['ulevel'];
        $cond['action_userlevel'] = $level;
    }

    if ($params['limit']) {
        $limit = $params['limit'];
    } else {
        $limit = 20;
    }

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $start = $limit * $page - $limit;
    } else {
        $start = 0;
    }

    $count = 0;
    $final_query = '';
    foreach ($cond as $field => $value) {
        if ($count > 0) {
            $final_query .= " AND `$field` = '$value' ";
        } else {
            $final_query .= " `$field` = '$value' ";
        }
        $count++;
    }
    if (!empty($cond)) {
        $final_query .= " ORDER BY `action_id` DESC LIMIT $start,$limit";
        $logs = Clipbucket_db::getInstance()->select(tbl("action_log"), "*", "$final_query");
    } else {
        $final_query = " `action_id` != '' ORDER BY `action_id` DESC LIMIT $start,$limit";
        $logs = Clipbucket_db::getInstance()->select(tbl("action_log"), "*", "$final_query");
    }
    if (is_array($logs)) {
        return $logs;
    }
    return false;
}

/**
 * Checks if a user has rated a video / photo and returns rating status
 *
 * @param      $userid
 * @param      $itemid
 * @param bool $type
 *
 * @return bool|string : { string / boolean } { rating status if found, else false }
 * @throws Exception
 * @internal param $ : { integer } { $userid } { id of user to check rating by } { $userid } { id of user to check rating by }
 * @internal param $ : { integer } { $itemid } { id of item to check rating for } { $itemid } { id of item to check rating for }
 * @internal param $ : { boolean } { false by default, type of item [video / photo] } { false by default, type of item [video / photo] }
 *
 * @example : has_rated(1,1033, 'video') // will check if userid 1 has rated video with id 1033
 * @since : 12th April, 2016 ClipBucket 2.8.1
 * @author : Saqib Razzaq
 */
function has_rated($userid, $itemid, $type = false)
{
    switch ($type) {
        case 'video':
            $toselect = 'videoid';
            $field = 'voter_ids';
            break;

        case 'photo':
            $type = 'photos';
            $toselect = 'photo_id';
            $field = 'voters';
            break;

        case 'user':
            $type = 'user_profile';
            $toselect = 'userid';
            $field = 'voters';
            break;

        default:
            error_log('has_rated unknown type : ' . $type . PHP_EOL);
            $type = 'video';
            $toselect = 'videoid';
            $field = 'voter_ids';
            break;
    }
    $raw_rating = Clipbucket_db::getInstance()->select(tbl($type), $field, "$toselect = $itemid");
    $ratedby_json = $raw_rating[0][$field];
    $ratedby_cleaned = json_decode($ratedby_json, true);
    foreach ($ratedby_cleaned as $rating_data) {
        if ($rating_data['userid'] == $userid) {
            if ($rating_data['rating'] == 0) {
                return 'disliked';
            }
            return 'liked';
        }
    }
    return false;
}

/**
 * Assigns smarty values to an array
 * @param : { array } { $vals } { an associative array to assign vals }
 */
function array_val_assign($vals)
{
    if (is_array($vals)) {
        foreach ($vals as $name => $value) {
            assign($name, $value);
        }
    }
}

function get_website_logo_path()
{
    $logo_name = config('logo_name');
    if ($logo_name && $logo_name != '') {
        return DirPath::getUrl('logos') . $logo_name;
    }
    if (defined('TEMPLATEURLFO')) {
        return TEMPLATEURLFO . '/theme' . '/images/logo.png';
    }
    return TEMPLATEURL . '/theme' . '/images/logo.png';
}

function get_website_favicon_path()
{
    $favicon_name = config('favicon_name');
    if ($favicon_name && $favicon_name != '') {
        return DirPath::getUrl('logos') . $favicon_name;
    }
    if (defined('TEMPLATEURLFO')) {
        return TEMPLATEURLFO . '/theme' . '/images/favicon.png';
    }
    return TEMPLATEURL . '/theme' . '/images/favicon.png';
}

/**
 * @throws Exception
 */
function upload_image($type = 'logo')
{
    if (!in_array($type, ['logo', 'favicon'])) {
        e(lang('Wrong logo type !'));
        return;
    }
    global $Cbucket;

    $filename = $_FILES['fileToUpload']['name'];
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $file_basename = pathinfo($filename, PATHINFO_FILENAME);
    $filesize = $_FILES['fileToUpload']['size'];
    $allowed_file_types = explode(',', strtolower($Cbucket->configs['allowed_photo_types']));

    if (in_array($file_ext, $allowed_file_types) && ($filesize < 4000000)) {
        // Rename file
        $logo_path = DirPath::get('logos') . $file_basename . '-' . $type . '.' . $file_ext;
        unlink($logo_path);
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $logo_path);

        $myquery = new myquery();
        $myquery->Set_Website_Details($type . '_name', $file_basename . '-' . $type . '.' . $file_ext);

        e(lang('File uploaded successfully.'), 'm');
    } elseif (empty($filename)) {
        // file selection error
        e(lang('Please select a file to upload.'));
    } elseif ($filesize > 4000000) {
        // file size error
        e(lang('The file you are trying to upload is too large.'), "e");
    } else {
        e(lang('Only these file types are allowed for upload: ' . implode(', ', $allowed_file_types)), "e");
        unlink($_FILES['fileToUpload']['tmp_name']);
    }
}

/**
 * Check for the content mime type of a file provided
 * @param : { FILE } { $mainFile } { File to run check against }
 * @param int $offset
 * @return false|string : { string/boolean } { type or false }
 * @since : 10 January, 2018
 * @todo : will Check for the content mime type of a file provided
 * @author : Fahad Abbas
 * @example : N/A
 */
function get_mime_type($file, $offset = 0)
{
    $raw_content_type = mime_content_type($file);
    $cont_type = substr($raw_content_type, $offset, strpos($raw_content_type, '/'));
    if ($cont_type) {
        return $cont_type;
    }
    return false;
}

function get_date_js()
{
    $date_format_php = config('date_format');
    $search = ['Y', 'm', 'd'];
    $replace = ['yy', 'mm', 'dd'];

    return str_replace($search, $replace, $date_format_php);
}

function isset_check($input_arr, $key_name, $mysql_clean = false)
{
    if (!empty($input_arr[$key_name])) {
        if (!is_array($input_arr[$key_name]) && !is_numeric($input_arr[$key_name]) && $mysql_clean) {
            $input_arr[$key_name] = mysql_clean($input_arr[$key_name]);
        }

        return $input_arr[$key_name];
    }
    return false;
}

/**
 * [generic_curl use to send curl with post method]
 * @param [string] $call_bk [url where curl will be sent]
 * @param [array] $array [date to be send ]
 * @param [string] $follow_redirect [ redirect follow option for 301 status ]
 * @param [array] $header_arr [ header's parameters are sent through this array ]
 * @param [bool] $read_response_headers [ parse/fetch the response headers ]
 * @return [array] [return code and result of curl]
 * @author Awais Tariq
 */
function generic_curl($input_arr = [])
{
    $call_bk = isset_check($input_arr, 'url');

    $array = isset_check($input_arr, 'post_arr');
    $file = isset_check($input_arr, 'file');
    $follow_redirect = isset_check($input_arr, 'redirect');
    $full_return_info = isset_check($input_arr, 'full_return_info');
    $header_arr = isset_check($input_arr, 'headers');
    $curl_timeout = isset_check($input_arr, 'curl_timeout');
    $methods = strtoupper(isset_check($input_arr, 'method'));
    $curl_connect_timeout = isset_check($input_arr, 'curl_connect_timeout');
    $curl_connect_timeout = (int)trim($curl_connect_timeout);
    $curl_timeout = (int)trim($curl_timeout);
    $read_response_headers = isset_check($input_arr, 'response_headers');
    $return_arr = [];
    if (!empty($call_bk)) {
        $ch = curl_init($call_bk);

        if (!empty($file)) {
            foreach ($file as $key => $value) {
                if (file_exists($value)) {
                    $array[$key] = curl_file_create($value, mime_content_type($value), basename($value));
                }
            }
        }

        if ($methods) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "{$methods}");
        }

        if (!empty($array)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        }

        if ($read_response_headers === true) {
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        if (empty($header_arr)) {
            $header_arr = ['Expect:'];
        }

        if (empty($curl_timeout) || $curl_timeout == 0) {
            $curl_timeout = 3;
        }

        if ($curl_timeout > 0) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $curl_timeout);
        }

        if (empty($curl_connect_timeout) || $curl_connect_timeout == 0) {
            $curl_connect_timeout = 2;
        }

        if ($curl_connect_timeout > 0) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $curl_connect_timeout);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_arr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($follow_redirect) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }

        $result = curl_exec($ch);
        $error_msg = curl_error($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($full_return_info) {
            $return_arr['full_info'] = curl_getinfo($ch);
        }

        $return_arr['code'] = $returnCode;
        $errorNO = curl_errno($ch);
        if ($errorNO) {
            $return_arr['curl_error_no'] = $errorNO;
        }

        if (!empty($error_msg)) {
            $return_arr['error_curl'] = $error_msg;
        }

        $return_arr['result'] = $result;
        curl_close($ch);
    } else {
        $return_arr['error'] = "False no callback url present! {$call_bk}";
    }

    return $return_arr;

}

/**
 * @param string $format
 * @param string $timeout
 * @return resource
 */
function get_proxy_settings(string $format = '', string $timeout = '')
{
    switch ($format) {
        default:
        case 'file_get_contents':
            $context = null;
            if (config('proxy_enable') == 'yes') {
                $context = [
                    'http' => [
                        'proxy'           => 'tcp://' . config('proxy_url') . ':' . config('proxy_port'),
                        'request_fulluri' => true
                    ]
                ];

                if (config('proxy_auth') == 'yes') {
                    $context['http']['header'] = 'Proxy-Authorization: Basic ' . base64_encode(config('proxy_username') . ':' . config('proxy_password'));
                }
            }
            if( !empty($timeout)) {
                $context['http']['timeout'] = (int)$timeout;
            }

            return stream_context_create($context);
    }
}

function error_lang_cli($msg)
{
    if (php_sapi_name() == 'cli') {
        echo $msg . PHP_EOL;
    } else {
        e($msg);
    }
}

function rglob($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $files = array_merge(
            [],
            ...[$files, rglob($dir . '/' . basename($pattern), $flags)]
        );
    }
    return $files;
}

/**
 * @param $path
 * @return bool
 */
function delete_empty_directories($path): bool
{
    if (!is_dir($path)) {
        return false;
    }
    $content = glob($path . '/*', GLOB_ONLYDIR);
    foreach ($content as $sub_dir) {
        delete_empty_directories($sub_dir);
    }
    $content = glob($path . '/*');
    // Si le répertoire est maintenant vide, le supprimer
    if (empty($content)) {
        rmdir($path);
        return true;
    }

    return false;
}

/**
 * @param array $list_language
 * @return array
 * @throws Exception
 */
function get_restorable_languages(array $list_language = []): array
{
    if (empty($list_language)) {
        $list_language = Language::getInstance()->get_langs(false, true);
    }
    $restorable_langs = [
        'en'    => 'English',
        'fr'    => 'Français',
        'pt-BR' => 'Portuguesa',
        'de'    => 'Deutsche',
        'esp'   => 'Español'
    ];

    return array_filter($restorable_langs, function ($lang) use ($list_language) {
        $column = array_column($list_language, 'language_name');
        return !in_array($lang, $column);
    });
}

function ageRestriction($var) {
    $var = (int)$var;
    if (empty($var)) {
        return 'null';
    }
    if ($var > 99 || $var < 0) {
        return false;
    }
    return $var;
}

include('functions_db.php');
include('functions_filter.php');
include('functions_player.php');
include('functions_template.php');
include('functions_helper.php');
include('functions_video.php');
include('functions_user.php');
include('functions_photo.php');
include('functions_actions.php');
include('functions_playlist.php');
