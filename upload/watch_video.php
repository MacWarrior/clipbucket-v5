<?php
define('THIS_PAGE', 'watch_video');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';
global $cbvid;

if (!User::getInstance()->hasPermission('view_video') || config('videosSection') != 'yes') {
    redirect_to(get_server_url());
}

$vkey = $_GET['v'] ?? false;

if( empty($vkey) ){
    redirect_to(get_server_url());
}

if(is_numeric($vkey)){
    $search = 'videoid';
} else {
    $search = 'videokey';
}

$vdo = Video::getInstance()->getOne([$search => $vkey]);
if( !video_playable($vdo) ) {
    redirect_to(get_server_url());
}

$assign_arry['vdo'] = $vdo;

$is_playlist = false;
if( config('playlistsSection') == 'yes' ){
    $playlist_id = (int)$_GET['play_list'];
    if( !empty($playlist_id) ){
        $playlist = Playlist::getInstance()->getAll([
            'first_only'  => true,
            'playlist_id' => $playlist_id
        ]);
        $assign_arry['playlist'] = $playlist;

        $playlist_items = $cbvid->get_playlist_items($playlist_id, 'playlist_items.date_added DESC');
        $assign_arry['playlist_items'] = $playlist_items;

        $is_playlist = true;
    }
}

if( config('collectionsSection') == 'yes' ){
    $params = [];
    $params['type'] = 'videos';

    if (!User::getInstance()->hasAdminAccess()) {
        $params['userid'] = user_id();
    }
    $collections = Collection::getInstance()->getAllIndent($params) ? : [];
    assign('collections', $collections);
    assign('item_id', $vdo['videoid']);
}

if( !$is_playlist ){
    $videoid = $vdo['videoid'];
    $related_videos = Video::getInstance()->getAll(['title' => $vdo['title'], 'tags' => $vdo['tags'], 'limit' => 12, 'order' => 'RAND()', 'join_user_profile'=>true, 'status'=>'Successful']);
    if ($related_videos) {
        $related_videos = array_filter($related_videos, function ($video) use ($videoid){
            return $video['videoid'] != $videoid;
        });
    }
    $relMode = '';
    if (!$related_videos) {
        $relMode = 'ono';
        $related_videos = Video::getInstance()->getAll(['limit' => 12, 'order' => 'date_added DESC', 'join_user_profile'=>true, 'status'=>'Successful']);
        if ($related_videos) {
            $related_videos = array_filter($related_videos, function ($video) use ($videoid) {
                return $video['videoid'] != $videoid;
            });
        }
    }
    $assign_arry['videos'] = $related_videos;
    $assign_arry['relMode'] = $relMode;
}

//Calling Functions When Video Is going to play
call_watch_video_function($vdo);
subtitle(ucfirst($vdo['title']));

# assigning all variables
array_val_assign($assign_arry);
$anonymous_id = userquery::getInstance()->get_anonymous_user();
assign('anonymous_id', $anonymous_id);
//link edit
assign('link_edit_bo', DirPath::getUrl('admin_area') . 'edit_video.php?video=' . $vdo['videoid']);
assign('link_edit_fo',  '/edit_video.php?vid=' . $vdo['videoid']);

$min_suffixe = in_dev() ? '' : '.min';

ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                               => 'admin'
    ,'pages/watch_video/watch_video' . $min_suffixe . '.js'       => 'admin'
    ,'init_readonly_tag/init_readonly_tag' . $min_suffixe . '.js' => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'      => 'admin'
    ,'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
    ,'readonly_tag' . $min_suffixe . '.css'     => 'admin'
]);

if( config('enable_comments_video') == 'yes' ){
    ClipBucket::getInstance()->addJS(['pages/add_comment/add_comment' . $min_suffixe . '.js' => 'admin']);

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

template_files('watch_video.html');
display_it();
