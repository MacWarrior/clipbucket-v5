<?php

/**
 * @throws Exception
 */
function is_playlist_viewable($list_id)
{
    if (is_array($list_id)) {
        $playlist = $list_id;
    } else {
        $playlist = Playlist::getInstance()->getOne($list_id);
    }

    if (isset($playlist['playlist_id'])) {
        if ($playlist['privacy'] == 'private' and $playlist['userid'] != user_id()) {
            e(lang('User has made this playlist private.'));
            return false;
        }

        $data = cb_do_action('is_playlist_viewable', ['playlist' => $playlist]);
        if ($data) {
            return $data;
        }

        return true;
    }

    return true;
}

/**
 * @throws Exception
 */
function get_playlist_items($list_id, $limit = -1, $order = "playlist_items.playlist_item_id DESC")
{
    global $cbvid;
    return $cbvid->get_playlist_items($list_id, $order, $limit);
}

/**
 * @throws Exception
 */
function get_playlist_thumb($playlist, $size = false)
{
    if (!$size) {
        $size = 'big';
    }

    $first_item = $playlist['first_item'];

    if (isset($first_item)) {

        if (!is_array($first_item)) {
            $first_item = json_decode($first_item, true);
        }

        $thumb = get_thumb($first_item, false, $size);

        if (strpos($thumb, 'processing') === false) {
            return $thumb;
        }
    }

    return get_playlist_default_thumb();
}

function get_playlist_default_thumb(): string
{
    $name = 'playlist_thumb.png';
    $template = TEMPLATEDIR;
    $images = DirPath::getUrl('images');

    $url = $images . $name;

    if (file_exists($template . '/images/' . $name)) {
        $url = TEMPLATEURL . '/images/' . $name;
    }

    return $url;
}

/**
 * @throws Exception
 */
function increment_playlist_played($args = [])
{
    if (isset($args['playlist'])) {
        $cookie = 'playlist_played_' . $args['playlist']['playlist_id'];
        if (!isset($_COOKIE[$cookie])) {
            Clipbucket_db::getInstance()->update(tbl('playlists'), ['played'], ['|f|played+1'], " playlist_id = '" . $args['playlist']['playlist_id'] . "' ");
            set_cookie_secure($cookie, true);
        }
    }
}

/**
 * Get playlists that have at least 1 item
 * @param : { array } { $playlists } { array of all playlists fetched from database }
 * @return array|void : { array } { $playlists } { playlists with items only }
 * @author : Saqib Razzaq
 *
 * @since : May 11th, 2016 ClipBucket 2.8.1
 */
function activePlaylists($playlists)
{
    if (is_array($playlists)) {
        foreach ($playlists as $key => $coll) {
            $totalObjs = $coll['total_items'];
            if ($totalObjs >= 1) {
                continue;
            } else {
                unset($playlists[$key]);
            }
        }
        return $playlists;
    }
}
