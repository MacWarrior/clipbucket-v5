<?php
define('THIS_PAGE', 'watch_video');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';
global $cbvid;

if (!userquery::getInstance()->perm_check('view_video', true) || config('videosSection') != 'yes') {
    redirect_to(BASEURL);
}

$vkey = $_GET['v'] ?? false;

if( empty($vkey) ){
    redirect_to(BASEURL);
}

if(is_numeric($vkey)){
    $search = 'videoid';
} else {
    $search = 'videokey';
}

$vdo = Video::getInstance()->getOne([$search => $vkey]);
if( !video_playable($vdo) ) {
    redirect_to(BASEURL);
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

    if (!has_access('admin_access')) {
        $params['userid'] = user_id();
    }
    $collections = Collection::getInstance()->getAllIndent($params) ? : [];
    assign('collections', $collections);
    assign('item_id', $vdo['videoid']);
}

if( !$is_playlist ){
    $videoid = $vdo['videoid'];
    $related_videos = get_videos(['title' => $vdo['title'], 'tags' => $vdo['tags'], 'exclude' => $videoid, 'show_related' => 'yes', 'limit' => 12, 'order' => 'RAND()']);
    $relMode = '';
    if (!$related_videos) {
        $relMode = 'ono';
        $related_videos = get_videos(['exclude' => $videoid, 'limit' => 12, 'order' => 'date_added DESC']);
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
assign('link_edit_bo', DirPath::get('admin_area',true) . 'edit_video.php?video=' . $vdo['videoid']);
assign('link_edit_fo',  '/edit_video.php?vid=' . $vdo['videoid']);

$min_suffixe = in_dev() ? '' : '.min';

ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                              => 'admin',
    'pages/watch_video/watch_video' . $min_suffixe . '.js'       => 'admin',
    'init_readonly_tag/init_readonly_tag' . $min_suffixe . '.js' => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin',
    'readonly_tag' . $min_suffixe . '.css'     => 'admin'
]);

template_files('watch_video.html');
display_it();
