<?php
define('THIS_PAGE', 'watch_video');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';
global $cbvid, $userquery, $pages, $Cbucket;
$perm = $userquery->perm_check('view_video', true);
$pages->page_redir();

if ($perm) {
    $vkey = @$_GET['v'];
    $vkey = mysql_clean($vkey);
    $vdo = $cbvid->get_video($vkey);
    $cbvid->update_comments_count($vdo['videoid']);
    $assign_arry['vdo'] = $vdo;
    if (video_playable($vdo)) {
        //Checking for playlist
        $pid = (int)$_GET['play_list'];
        if (!empty($pid)) {
            $plist = get_playlist($pid);
            if ($plist) {
                $assign_arry['playlist'] = $plist;
            }
        }
        //Calling Functions When Video Is going to play
        call_watch_video_function($vdo);
        subtitle(ucfirst($vdo['title']));
    } else {
        $Cbucket->show_page = false;
    }

    //Return category id without '#'
    $v_cat = $vdo['category'];
    if ($v_cat[2] == '#') {
        $video_cat = $v_cat[1];
    } else {
        $video_cat = $v_cat[1] . $v_cat[2];
    }
    $vid_cat = str_replace('%#%', '', $video_cat);
    $assign_arry['vid_cat'] = $vid_cat;
    $title = $vdo['title'];
    $tags = $vdo['tags'];
    $videoid = $vdo['videoid'];
    $related_videos = get_videos(['title' => $title, 'tags' => $tags, 'exclude' => $videoid, 'show_related' => 'yes', 'limit' => 12, 'order' => 'RAND()']);
    if (!$related_videos) {
        $relMode = 'ono';
        $related_videos = get_videos(['exclude' => $videoid, 'limit' => 12, 'order' => 'date_added DESC']);
    }
    $playlist = $cbvid->action->get_playlist($pid, user_id());
    $assign_arry['playlist'] = $playlist;
    //Getting Playlist Item
    $items = $cbvid->get_playlist_items($pid, 'playlist_items.date_added DESC');
    $assign_arry['items'] = $items;
    $assign_arry['videos'] = $related_videos;
    $assign_arry['relMode'] = $relMode;
    # assigning all variables
    array_val_assign($assign_arry);
    template_files('watch_video.html');
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

$Cbucket->addJS([
    'tag-it' . $min_suffixe . '.js'                              => 'admin',
    'pages/watch_video/watch_video' . $min_suffixe . '.js'       => 'admin',
    'init_readonly_tag/init_readonly_tag' . $min_suffixe . '.js' => 'admin'
]);
$Cbucket->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin',
    'readonly_tag' . $min_suffixe . '.css'     => 'admin'
]);

display_it();
