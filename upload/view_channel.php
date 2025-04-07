<?php
define('THIS_PAGE', 'view_channel');
define('PARENT_PAGE', 'channels');

require 'includes/config.inc.php';

if( !isSectionEnabled('channels') || !User::getInstance()->hasPermission('view_channel')){
    redirect_to(Network::get_server_url());
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
    sessionMessageHandler::add_message(lang('channel_doesnt_exists'), 'e', Network::get_server_url() . 'channels.php');
}
if ($udetails['ban_status'] == 'yes') {
    e(lang('usr_uban_msg'));
    if (!User::getInstance()->hasAdminAccess()) {
        ClipBucket::getInstance()->show_page = false;
        display_it();
        exit();
    }
}

assign('user', $udetails);

if( config('enable_user_category')=='yes' ){
    $category_links = [];
    foreach (json_decode($udetails['category_list'],true) as $user_category) {
        $category_links[] = '<a href="' . cblink(['name' => 'category', 'data' => ['category_id' => $user_category['id'], 'category_name' => $user_category['name']], 'type' => 'channel']) . '">' . display_clean($user_category['name']) . '</a>';
    }
    assign('category_links', implode(',', $category_links));
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

        if (!User::getInstance()->hasAdminAccess()) {
            ClipBucket::getInstance()->show_page = false;
        }
    }
    //Checking if user is not banned by admin
    if (user_id()) {
        if (userquery::getInstance()->is_user_banned(user_name(), $udetails['userid'], $udetails['banned_users'])) {
            e(lang('you_are_not_allowed_to_view_user_channel', $udetails['username']));
            assign('isBlocked', 'yes');
            if (!User::getInstance()->hasAdminAccess()) {
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

    if( config('enable_comments_channel') == 'yes' ){
        ClipBucket::getInstance()->addJS([
            'pages/add_comment/add_comment' . $min_suffixe . '.js'  => 'admin'
        ]);

        if( config('enable_visual_editor_comments') == 'yes' ){
            ClipBucket::getInstance()->addJS(['toastui/toastui-editor-all' . $min_suffixe . '.js' => 'libs']);
            ClipBucket::getInstance()->addCSS(['toastui/toastui-editor' . $min_suffixe . '.css' => 'libs']);

            $filepath = DirPath::get('libs') . 'toastui' . DIRECTORY_SEPARATOR . 'toastui-editor-' . config('default_theme') . $min_suffixe . '.css';
            if( config('default_theme') != '' && file_exists($filepath) ){
                ClipBucket::getInstance()->addCSS([
                    'toastui/toastui-editor-' . config('default_theme') . $min_suffixe . '.css' => 'libs'
                ]);
            }

            $filepath = DirPath::get('libs') . 'toastui' . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . strtolower(Language::getInstance()->getLang()) . $min_suffixe . '.js';
            if( file_exists($filepath) ){
                ClipBucket::getInstance()->addJS([
                    'toastui/i18n/' . strtolower(Language::getInstance()->getLang()) . $min_suffixe . '.js' => 'libs'
                ]);
            }
        }
    }

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
    $first_video_key = userMainVideo($videos);
    foreach ($videos as $video) {
        if ($first_video_key == $video['videokey']) {
            assign('first_video', $video);
        }
    }
    $ids_to_check_progress = [];
    $display_type='';
    if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '271') ) {
        $display_type = 'view_channel';
        foreach ($videos as $video) {
            if (in_array($video['status'], ['Processing', 'Waiting'])) {
                $ids_to_check_progress[] = $video['videoid'];
                if ($first_video_key == $video['videokey']) {
                    $display_type = 'view_channel_player';
                }
            }
        }
    }
    Assign('ids_to_check_progress', json_encode($ids_to_check_progress));
    Assign('display_type', $display_type);

    assign('uservideos', $videos);
    $popular_users = User::getInstance()->getAll([
        'order'=>'users.profile_hits DESC',
        'limit'=>'5',
        'channel_enable'=>true,
        'condition'=>'usr_status = \'ok\' AND users.userid != \''. mysql_clean($udetails['userid']).'\''
    ]);
    assign('popular_users',$popular_users);
}

display_it();
