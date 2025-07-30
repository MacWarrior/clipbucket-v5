<?php
const THIS_PAGE = 'edit_account';

require 'includes/config.inc.php';
User::getInstance()->isUserConnectedOrRedirect();

//Updating Profile
if (isset($_POST['update_profile'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    /*Checks profile fields data*/
    $post_clean = profile_fileds_check($array);
    if ($post_clean) {
        userquery::getInstance()->update_user($array);
    }
}

//Updating Avatar
if (isset($_POST['update_avatar_bg'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    userquery::getInstance()->update_user_avatar_bg($array);
}

if (isset($_FILES['Filedata'])) {
    $user_id = user_id();
    if( !$user_id ){
        echo json_encode([
            'error' => lang('insufficient_privileges_loggin')
        ]);
        die();
    }
    $timeStamp = time();
    $destinationFilePath = DirPath::get('temp') . 'background-' . $user_id . '-'. $timeStamp;

    $params = [
        'fileData'            => 'Filedata',
        'mimeType'            => 'image',
        'destinationFilePath' => $destinationFilePath,
        'keepExtension'       => true,
        'maxFileSize'         => config('max_bg_size') / 1024,
        'allowedExtensions'   => config('allowed_photo_types')
    ];

    FileUpload::getInstance($params)->processUpload();
    $data = [
        'extension' => FileUpload::getInstance()->getExtension(),
        'filepath'  => FileUpload::getInstance()->getDestinationFilePath(),
        'user_id'   => $user_id
    ];

    $coverUpload = userquery::getInstance()->updateBackground($data);
    $response = [
        'status' => $coverUpload['status'],
        'msg'    => $coverUpload['msg'],
        'url'    => userquery::getInstance()->getBackground(user_id()) . '?' . $timeStamp
    ];
    echo json_encode($response);
    die();
}

//Changing Email
if (isset($_POST['change_email'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    userquery::getInstance()->change_email($array);
}

//Changing User Password
if (isset($_POST['change_password'])) {
    $array = $_POST;
    $array['userid'] = user_id();
    userquery::getInstance()->change_password($array);
}

//Banning Users
if (isset($_POST['block_users'])) {
    userquery::getInstance()->block_users($_POST['users']);
}

$mode = $_GET['mode'];
if ($mode === 'profile' && !User::getInstance()->hasPermission('enable_channel_page')) {
    e(lang('cannot_access_page'));
    $mode = 'account';
}
assign('mode', $mode);

$params = [
    'userid' => user_id(),
    'limit'  => $sql_limit ?? '',
    'order'  => ' date_start DESC '
];

switch ($mode) {
    default:
        redirect_to(cblink(['name' => 'my_account']));

    case 'account':
        if( $_POST['drop_account'] ?? '' == 'yes' && config('enable_user_self_deletion') == 'yes' ){
            User::getInstance()->delete();
            userquery::getInstance()->logout();
            Session::start();
            sessionMessageHandler::add_message(lang('account_deleted'), 'm', DirPath::getUrl('root'));
        }
        assign('on', 'account');
        assign('mode', 'account_settings');
        break;

    case 'profile':
        assign('on', 'profile');
        assign('mode', 'profile_settings');
        break;

    case 'avatar_bg':
        if( (config('picture_upload') != 'yes' || !User::getInstance()->hasPermission('avatar_upload')) && config('picture_url') != 'yes' && empty(User::getInstance()->get('avatar_url')) && empty(User::getInstance()->get('avatar'))) {
            redirect_to(cblink(['name' => 'my_account']));
        }

        assign('mode', $mode);
        break;

    case 'block_users':
    case 'change_password':
    case 'change_email':
    case 'mfa':
        assign('mode', $mode);
        break;

    case 'subscriptions':
        if( config('channelsSection') != 'yes' || !User::getInstance()->hasPermission('view_channels') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        //Removing subscription
        if (isset($_GET['delete_subs'])) {
            $sid = mysql_clean($_GET['delete_subs']);
            userquery::getInstance()->unsubscribe_user($sid);
        }
        assign('mode', 'subs');
        assign('subs', userquery::getInstance()->get_user_subscriptions(user_id()));
        break;
}

$udetails = User::getInstance()->getOne(['userid'=>User::getInstance()->getCurrentUserID()]);
$profile = userquery::getInstance()->get_user_profile($udetails['userid']);
if (is_array($profile)) {
    $udetails = array_merge($profile, $udetails);
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/edit_account/edit_account' . $min_suffixe . '.js'   => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'plupload/js/moxie' . $min_suffixe . '.js'                 => 'admin',
    'plupload/js/plupload' . $min_suffixe . '.js'              => 'admin'
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
assign('signup_fields', userquery::getInstance()->load_signup_fields($udetails));
assign('cust_signup_fields', userquery::getInstance()->load_custom_signup_fields($udetails,false,true));

subtitle(lang('user_manage_my_account'));
template_files('edit_account.html');
display_it();
