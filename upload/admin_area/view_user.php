<?php
global $userquery, $pages, $myquery, $Cbucket, $Cbucket;

require_once '../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();
$userquery->login_check('member_moderation');

$uid = $_GET['uid'];
$udetails = $userquery->get_user_details($uid);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('users'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('grp_manage_members_title'),
    'url'   => ADMIN_BASEURL . '/members.php'
];
$breadcrumb[2] = [
    'title' => 'Editing : ' . display_clean($udetails['username']),
    'url'   => ADMIN_BASEURL . '/view_user.php?uid=' . display_clean($uid)
];

$row = $myquery->Get_Website_Details();
if ($udetails) {
    //Deactivating User
    if (isset($_GET['deactivate'])) {
        $userquery->action('deactivate', $uid);
        $udetails = $userquery->get_user_details($uid);
    }

    //Activating User
    if (isset($_GET['activate'])) {
        $userquery->action('activate', $uid);
        $udetails = $userquery->get_user_details($uid);
    }

    //Banning User
    if (isset($_GET['ban'])) {
        $userquery->action('ban', $uid);
        $udetails = $userquery->get_user_details($uid);
    }

    //Unbanning User
    if (isset($_GET['unban'])) {
        $userquery->action('unban', $uid);
        $udetails = $userquery->get_user_details($uid);
    }

    //Deleting User
    if (isset($_GET['delete'])) {
        $userquery->delete_user($uid);
    }

    //Deleting User Videos
    if (isset($_GET['delete_vids'])) {
        $userquery->delete_user_vids($uid);
    }

    //Deleting User Contacts
    if (isset($_GET['delete_contacts'])) {
        $userquery->remove_contacts($uid);
    }

    //Deleting User Pms
    if (isset($_GET['delete_pms'])) {
        $userquery->remove_user_pms($uid);
    }

    if (isset($_POST['update_user'])) {
        $userquery->update_user($_POST);
        if (!error()) {
            $udetails = $userquery->get_user_details($uid);
        }
    }

    $profile = $userquery->get_user_profile($udetails['userid']);
    if (is_array($profile)) {
        $user_profile = array_merge($udetails, $profile);
    } else {
        $user_profile = $udetails;
    }

    assign('u', $udetails);
    assign('p', $user_profile);
    assign('catparmas', 'catparmas');
} else {
    e('No User Found');
    $Cbucket->show_page = false;
}
if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

$Cbucket->addAdminJS([
    'pages/view_user/view_user' . $min_suffixe . '.js'         => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'tag-it' . $min_suffixe . '.js'                            => 'admin'
]);
$Cbucket->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('profile');
assign('available_tags',$available_tags);

assign('signup_fields', $userquery->load_signup_fields($udetails));

$channel_profile_fields = $userquery->load_user_fields($user_profile);

$location_fields = [];
foreach($channel_profile_fields AS $field){
    if( $field['group_id'] == 'profile_location'){
        $location_fields = $field;
        break;
    }
}
assign('location_fields', $location_fields);

$education_interests_fields = [];
foreach($channel_profile_fields AS $field){
    if( $field['group_id'] == 'profile_education_interests'){
        $education_interests_fields = $field;
        break;
    }
}
assign('education_interests_fields', $education_interests_fields);

$profile_basic_info = [];
foreach($channel_profile_fields AS $field){
    if( $field['group_id'] == 'profile_basic_info'){
        $profile_basic_info = $field;
        break;
    }
}
assign('profile_basic_info', $profile_basic_info);

$channel_settings = [];
foreach($channel_profile_fields AS $field){
    if( $field['group_id'] == 'channel_settings'){
        $channel_settings = $field;
        break;
    }
}
assign('channel_settings', $channel_settings);
assign('enable_user_dob_edition', $row['enable_user_dob_edition']);
subtitle('View User');
template_files('view_user.html');
display_it();
