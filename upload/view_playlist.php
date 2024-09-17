<?php
define('THIS_PAGE', 'view_playlist');
define('PARENT_PAGE', 'videos');

require 'includes/config.inc.php';

$pages->page_redir();

$list_id = mysql_clean($_GET['list_id']);

$playlist = Playlist::getInstance()->getOne($list_id);

if (is_playlist_viewable($playlist) and isset($playlist)) {

    $items = get_playlist_items($list_id);

    if (!empty($items)) {
        $playlist['videos'] = $items;
    }

    cb_do_action('view_playlist', [
        'playlist' => $playlist
    ]);

    assign('playlist', $playlist);

    subtitle($playlist['playlist_name']);
} else {
    ClipBucket::getInstance()->show_page = false;
}

//Displaying The Template
template_files('view_playlist.html');
display_it();