<?php
define('THIS_PAGE', 'edit_account');

global $userquery;

require 'includes/config.inc.php';
$userquery->logincheck();

//Updating Profile
if (isset($_POST['update_profile'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    /*Checks profile fields data*/
    $post_clean = profile_fileds_check($array);
    if ($post_clean) {
        $userquery->update_user($array);
    }
}

//Updating Avatar
if (isset($_POST['update_avatar_bg'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    $userquery->update_user_avatar_bg($array);
}

if (isset($_FILES['backgroundPhoto'])) {
    if (get_mime_type($_FILES['backgroundPhoto']['tmp_name']) == 'image') {
        $extension = getExt($_FILES['backgroundPhoto']['name']);
        $types = strtolower(config('allowed_photo_types'));
        $supported_extensions = explode(',', $types);

        if (!in_array($extension, $supported_extensions)) {
            $response = [
                'status' => false,
                'msg'    => 'Invalid extension provided',
                'url'    => false
            ];
            echo json_encode($response);
            die();
        }

        $array = $_FILES['backgroundPhoto'];
        $array['userid'] = user_id();
        $coverUpload = $userquery->updateBackground($array);
        $timeStamp = time();
        $response = [
            'status' => $coverUpload['status'],
            'msg'    => $coverUpload['msg'],
            'url'    => $userquery->getBackground(user_id()) . '?' . $timeStamp
        ];
        echo json_encode($response);
        die();
    }
    $response = [
        'status' => false,
        'msg'    => 'Invalid Image provided',
        'url'    => false
    ];
    echo json_encode($response);
    die();
}

//Changing Email
if (isset($_POST['change_email'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    $userquery->change_email($array);
}

//Changing User Password
if (isset($_POST['change_password'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    $userquery->change_password($array);
}

//Banning Users
if (isset($_POST['block_users'])) {
    $userquery->block_users($_POST['users']);
}

$mode = $_GET['mode'];


assign('mode', $mode);

switch ($mode) {
    case 'account':
        assign('on', 'account');
        assign('mode', 'account_settings');
        break;

    case 'profile':
        assign('on', 'profile');
        assign('mode', 'profile_settings');
        break;

    case 'avatar_bg':
        Assign('extensions', ClipBucket::getInstance()->get_extensions('photo'));
        assign('backgroundPhoto', $userquery->getBackground(user_id()));
        assign('mode', 'avatar_bg');
        break;

    case 'channel_bg':
        Assign('extensions', ClipBucket::getInstance()->get_extensions('photo'));
        assign('backgroundPhoto', $userquery->getBackground(user_id()));
        assign('mode', 'channel_bg');
        break;

    case 'change_cover':
        Assign('extensions', ClipBucket::getInstance()->get_extensions('photo'));
        assign('backgroundPhoto', $userquery->getBackground(user_id()));
        assign('mode', 'change_cover');
        break;

    case 'change_email':
        assign('mode', 'change_email');
        break;

    case 'change_password':
        assign('mode', 'change_password');
        break;

    case 'block_users':
        assign('mode', 'block_users');
        break;

    case 'subscriptions':
        //Removing subscription
        if (isset($_GET['delete_subs'])) {
            $sid = mysql_clean($_GET['delete_subs']);
            $userquery->unsubscribe_user($sid);
        }
        assign('mode', 'subs');
        assign('subs', $userquery->get_user_subscriptions(user_id()));
        break;

    default:
        assign('on', 'account');
        assign('mode', 'profile_settings');
        break;
}

$udetails = $userquery->get_user_details(user_id());
$profile = $userquery->get_user_profile($udetails['userid']);
if (is_array($profile)) {
    $udetails = array_merge($udetails, $profile);
}
if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/edit_account/edit_account' . $min_suffixe . '.js'   => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit'.$min_suffixe.'.css' => 'admin',
    'tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin'
]);

$datepicker_js_lang = '';
if( Language::getInstance()->getLang() != 'en'){
    $datepicker_js_lang = '_languages/datepicker-'.Language::getInstance()->getLang();
}
ClipBucket::getInstance()->addJS(['jquery_plugs/datepicker'.$datepicker_js_lang.'.js' => 'global']);

$available_tags = Tags::fill_auto_complete_tags('profile');
assign('available_tags', $available_tags);

assign('user', $udetails);

assign('signup_fields', $userquery->load_signup_fields($udetails));
assign('cust_signup_fields', $userquery->load_custom_signup_fields($udetails,false,true));
assign('myAccountLinks', $userquery->my_account_links());

subtitle(lang('user_manage_my_account'));
template_files('edit_account.html');
display_it();
