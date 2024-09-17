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

function get_playlist_cover($playlist, $return_default = false)
{
    $cover = $playlist['cover'];
    $playlist_dir = DirPath::get('playlist_covers');

    if (empty($cover)) {
        return $return_default ? get_playlist_default_thumb() : false;
    }

    if (file_exists($playlist_dir . $cover)) {
        return DirPath::getUrl('playlist_covers') . $cover;
    }

    return $return_default ? get_playlist_default_thumb() : false;
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

    $thumb = get_playlist_cover($playlist);

    return ($thumb ? $thumb : get_playlist_default_thumb());
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

function view_playlist($playlist_id)
{
    $playlist_link = BASEURL;

    if (is_array($playlist_id) and isset($playlist_id['playlist_id'])) {
        $playlist = $playlist_id;
    } else {
        $playlist = Playlist::getInstance()->getOne($playlist_id);
    }

    if (empty($playlist)) {
        return BASEURL;
    }

    $is_seo = SEO;


    $data = cb_do_action('view_playlist_link', ['playlist' => $playlist, 'seo_enabled' => $is_seo]);

    if ($is_seo) {
        $playlist_link .= '/list/' . $playlist['playlist_id'] . '/' . SEO($playlist['playlist_name']);
    } else {
        $playlist_link .= '/view_playlist.php?list=' . $playlist_id;
    }


    $data = cb_do_action('view_playlist_link', [
        'playlist'      => $playlist,
        'seo_enabled'   => $is_seo,
        'playlist_link' => $playlist_link
    ]);

    if ($data) {
        return $data;
    }

    return $playlist_link;
}

/**
 * @throws Exception
 */
function playlist_upload_cover($args): bool
{
    $filename = $args['playlist_id'];
    $extension = getExt($args['name']);
    $folder = create_dated_folder(DirPath::get('playlist_covers'));
    $uploaded_file = DirPath::get('playlist_covers') . $folder . '/' . $filename . '.' . $extension;

    if (!empty($filename)) {
        if (move_uploaded_file($args['tmp_name'], $uploaded_file)) {
            $cover_name = $filename . '.' . $extension;

            $resizer = new CB_Resizer($uploaded_file);
            $resizer->target = $uploaded_file;
            $resizer->resize(1280, 800);
            $resizer->save();

            Clipbucket_db::getInstance()->update(tbl('playlists'), ['cover'], [$folder . '/' . $cover_name], " playlist_id = '" . $filename . "' ");
            return true;
        }
    }

    return false;
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
 * @return : { array } { $playlists } { playlists with items only }
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
