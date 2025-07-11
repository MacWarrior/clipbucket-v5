<?php
const THIS_PAGE = 'view_channel';
const PARENT_PAGE = 'channels';

require 'includes/config.inc.php';

pages::getInstance()->page_redir();

if( !isSectionEnabled('channels') || !User::getInstance()->hasPermission('view_channel')){
    redirect_to(DirPath::getUrl('root'));
}

$u = $_GET['user'] ?? null;

if( empty($u) ){
    sessionMessageHandler::add_message(lang('channel_doesnt_exists'), 'e', cblink(['name' => 'channels']));
}

$params_user = [
    'channel_enable' => true
    ,'username' => $u
];

$udetails = User::getInstance()->getOne($params_user);
if (!$udetails || $udetails['userid'] == userquery::getInstance()->get_anonymous_user() ) {
    sessionMessageHandler::add_message(lang('channel_doesnt_exists'), 'e', cblink(['name' => 'channels']));
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


//Checking Profile permissions
$perms = $p['show_profile'];
if (user_id() != $udetails['userid']) {
    if (($perms == 'friends' || $perms == 'members') && !user_id()) {
        e(lang('you_cant_view_profile'));
        ClipBucket::getInstance()->show_page = false;
        display_it();
        exit();
    }
    if ($perms == 'friends' && !userquery::getInstance()->is_confirmed_friend($udetails['userid'], user_id())) {
        e(lang('only_friends_view_channel', $udetails['username']));

        if (!User::getInstance()->hasAdminAccess()) {
            ClipBucket::getInstance()->show_page = false;
            display_it();
            exit();
        }
    }
    //Checking if user is not banned by admin
    if (user_id() && userquery::getInstance()->is_user_banned(user_name(), $udetails['userid'], $udetails['banned_users'])) {
        e(lang('you_are_not_allowed_to_view_user_channel', $udetails['username']));
        assign('isBlocked', 'yes');
        if (!User::getInstance()->hasAdminAccess()) {
            ClipBucket::getInstance()->show_page = false;
            display_it();
            exit();
        }
    }
}

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

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'pages/view_channel/view_channel'.$min_suffixe.'.js'      => 'admin'
    ,'plupload/js/plupload.full.min.js'                       => 'admin'
]);

if( config('enable_comments_channel') == 'yes' ){
    ClipBucket::getInstance()->addJS([
        'pages/add_comment/add_comment' . $min_suffixe . '.js'  => 'admin'
    ]);
    Comments::initVisualComments();
}

if( !empty($udetails['tags']) ){
    ClipBucket::getInstance()->addJS([
        'tag-it'.$min_suffixe.'.js'                               => 'admin'
        ,'init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js' => 'admin'
    ]);
    ClipBucket::getInstance()->addCSS([
        'jquery.tagit'.$min_suffixe.'.css'      => 'admin'
        ,'tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin'
        ,'readonly_tag'.$min_suffixe.'.css'     => 'admin'
    ]);
}

$popular_users = User::getInstance()->getAll([
    'order'          => 'users.profile_hits DESC',
    'limit'          => '5',
    'channel_enable' => true,
    'ban_status'     => 'no',
    'condition'      => 'usr_status = \'ok\' AND users.userid != '. (int)$udetails['userid']
]);
assign('popular_users',$popular_users);

$user_feeds = cbfeeds::getInstance()->getUserFeeds($udetails);
assign('userFeeds', $user_feeds);

if( isSectionEnabled('videos') ){
    if( User::getInstance($udetails['userid'])->get('show_my_videos') == 'yes' ){
        $params = [
            'userid' => $udetails['userid']
            ,'order' => 'date_added DESC'
            ,'limit' => config('videos_item_channel_page')
        ];
        $videos = Video::getInstance()->getAll($params);
    $first_video = $videos[0];
    assign('first_video', $first_video);
        $ids_to_check_progress = [];
        $display_type='';
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '271') ) {
            $display_type = 'view_channel';
            foreach ($videos as $video) {
                if (in_array($video['status'], ['Processing', 'Waiting'])) {
                    $ids_to_check_progress[] = $video['videoid'];
                    if ($first_video['videokey'] == $video['videokey']) {
                        $display_type = 'view_channel_player';
                    }
                }
            }
        }
        assign('ids_to_check_progress', json_encode($ids_to_check_progress));
        assign('display_type', $display_type);
        assign('uservideos', $videos);
    }

    if( config('playlistsSection') == 'yes' ){
        $playlists = Playlist::getInstance()->getAll([
            'userid'=>$udetails['userid']
            ,'order'=>'date_added DESC'
        ]);
        assign('playlists', $playlists);
    }

}

if( isSectionEnabled('photos') && User::getInstance($udetails['userid'])->get('show_my_photos') == 'yes' ){
    $photos = Photo::getInstance()->getAll([
        'userid'=>$udetails['userid'],
        'limit'=>config('photo_channel_page')
    ]);
    assign('photos', $photos);
}

if( isSectionEnabled('videos') && User::getInstance($udetails['userid'])->get('show_my_videos') == 'yes' && !empty($videos) && count($videos) > 0 ){
    $default_tab = 'video';
} else if( isSectionEnabled('photos') && User::getInstance($udetails['userid'])->get('show_my_photos') == 'yes' && !empty($photos) && count($photos) > 0 ){
    $default_tab = 'photo';
} else {
    $default_tab = 'info';
}
assign('default_tab', $default_tab);

subtitle(lang('user_s_channel', $udetails['username']));
display_it();
