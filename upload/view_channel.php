<?php
define('THIS_PAGE', 'view_channel');
define('PARENT_PAGE', 'channels');

require 'includes/config.inc.php';

if( !isSectionEnabled('channels') || !userquery::getInstance()->perm_check('view_channel', true)){
    redirect_to(BASEURL);
}

pages::getInstance()->page_redir();

$u = $_GET['user'];
$u = $u ?: $_GET['userid'];
$u = $u ?: $_GET['username'];
$u = $u ?: $_GET['uid'];
$u = $u ?: $_GET['u'];
$u = mysql_clean($u);

$params_user = ['channel_enable' => true];
if (is_int($u)) {
    $params_user['userid']=$u;
} else {
    $params_user['username']=$u;

}
$udetails = User::getInstance()->getOne($params_user);
if (!$udetails || $udetails['userid'] == userquery::getInstance()->get_anonymous_user() ) {
    if ($_GET['seo_diret'] != 'yes' ) {
        redirect_to('/channels.php?no_user=1');
    } else {
        header('HTTP/1.0 404 Not Found');
        if (file_exists(LAYOUT . '/404.html')) {
            template_files('404.html');
        } else {
            $data = '404_error';
            if (has_access('admin_access')) {
                e(lang('err_warning', ['404', 'http://docs.clip-bucket.com/?p=154']), 'w');
            }
            e(lang($data));
        }
    }
    display_it();
    exit();
}
if ($udetails['ban_status'] == 'yes') {
    e(lang('usr_uban_msg'));
    if (!has_access('admin_access', true)) {
        ClipBucket::getInstance()->show_page = false;
        display_it();
        exit();
    }
}

assign('user', $udetails);

if( config('enable_user_category')=='yes' ){
    $user_category = Category::getInstance()->getById($udetails['id_category']);
    assign('user_category', $user_category['category_name']);
}

//Subscribing User
if ($_GET['subscribe']) {
    userquery::getInstance()->subscribe_user($udetails['userid']);
}

//Calling view channel functions
call_view_channel_functions($udetails);

//Getting profile details
$p = userquery::getInstance()->get_user_profile($udetails['userid']);
assign('p', $p);
assign('backgroundPhoto', userquery::getInstance()->getBackground($udetails['userid']));
assign('extensions', ClipBucket::getInstance()->get_extensions('photo'));

//Getting users channel List
$result_array['order'] = ' profile_hits DESC limit 6';
$users = get_users($result_array);
assign('users', $users);

//Checking Profile permissions
$perms = $p['show_profile'];
if (user_id() != $udetails['userid']) {
    if (($perms == 'friends' || $perms == 'members') && !user_id()) {
        e(lang('you_cant_view_profile'));
        ClipBucket::getInstance()->show_page = false;
    } elseif ($perms == 'friends' && !userquery::getInstance()->is_confirmed_friend($udetails['userid'], user_id())) {
        e(lang('only_friends_view_channel', $udetails['username']));

        if (!has_access('admin_access', true)) {
            ClipBucket::getInstance()->show_page = false;
        }
    }
    //Checking if user is not banned by admin
    if (user_id()) {
        if (userquery::getInstance()->is_user_banned(user_name(), $udetails['userid'], $udetails['banned_users'])) {
            e(lang('you_are_not_allowed_to_view_user_channel', $udetails['username']));
            assign('isBlocked', 'yes');
            if (!has_access('admin_access', true)) {
                ClipBucket::getInstance()->show_page = false;
            }
        }
    }
}

subtitle(lang('user_s_channel', $udetails['username']));

if( ClipBucket::getInstance()->show_page ){

    assign('photos', Photo::getInstance()->getAll([
        'userid'=>$udetails['userid'],
        'limit'=>9
    ]));

    $channel_profile_fields = userquery::getInstance()->load_user_fields($p,'profile');

    $location_fields = [];
    foreach($channel_profile_fields AS $field){
        if( $field['group_id'] == 'profile_location'){
            $location_fields = $field;
            break;
        }
    }
    assign('location_fields', $location_fields);

    assign('channel_profile_fields', $channel_profile_fields);

    template_files('view_channel.html');

    $min_suffixe = in_dev() ? '' : '.min';
    ClipBucket::getInstance()->addJS([
        'pages/view_channel/view_channel'.$min_suffixe.'.js'      => 'admin'
        ,'plupload/js/plupload.full.min.js'                       => 'admin'
        ,'tag-it'.$min_suffixe.'.js'                              => 'admin'
        ,'init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js' => 'admin'
    ]);

    ClipBucket::getInstance()->addCSS([
        'jquery.tagit'.$min_suffixe.'.css'      => 'admin'
        ,'tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin'
        ,'readonly_tag'.$min_suffixe.'.css'     => 'admin'
    ]);

    $params = [
        'userid' => $udetails['userid']
        ,'order' => 'date_added DESC'
        ,'limit' => 9
    ];
    $videos = Video::getInstance()->getAll($params);

    assign('uservideos', $videos);
    $popular_users = User::getInstance()->getAll([
        'order'=>'users.profile_hits DESC',
        'limit'=>'5',
        'condition'=>'usr_status = \'ok\' AND users.userid != \''. mysql_clean($udetails['userid']).'\''
    ]);
    assign('popular_users',$popular_users);
}

display_it();
