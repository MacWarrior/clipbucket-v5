<?php
define('THIS_PAGE', 'manage_playlists');
define('PARENT_PAGE', 'videos');

require 'includes/config.inc.php';

if( config('videosSection') != 'yes' || config('playlistsSection') != 'yes' ){
    redirect_to(BASEURL);
}

global $cbvid, $eh;

userquery::getInstance()->logincheck();
$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$mode = $_GET['mode'];

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('videos_list_per_page'));

switch ($mode) {
    case 'manage_playlist':
    case 'manage_video_playlist':
    default:
        //Deleting Playlist
        if (!empty($_GET['delete_pl'])) {
            $cbvid->action->delete_playlist($_GET['delete_pl']);
        }

        if (isset($_POST['delete_playlists'])) {
            $playlists = post('check_playlist');

            if (!empty($playlists) && count($playlists) > 0) {
                foreach ($playlists as $playlist) {
                    $cbvid->action->delete_playlist($playlist);
                }

                $eh->flush();
                if (!error()) {
                    e(lang('playlists_have_been_removed'), 'm');
                } else {
                    e(lang('playlist_not_exist'));
                }
            } else {
                e(lang('no_playlist_was_selected_to_delete'));
            }

        }

        //Adding New Playlist
        if (isset($_POST['add_playlist'])) {
            $cbvid->action->create_playlist($_POST);
        }

        assign('mode', 'manage_playlist');
        //Getting List of available playlists
        $playlists = Playlist::getInstance()->getAll([
            'userid'  => user_id(),
            'order' => 'playlists.date_added DESC'
        ]);
        assign('playlists', $playlists);
        break;

    case 'edit_playlist':
        if (isset($_POST['delete_playlist_item'])) {
            $items = post('check_playlist_items');
            if (is_array($items) && count($items) > 0) {
                foreach ($items as $item) {
                    $item = mysql_clean($item);
                    $cbvid->action->delete_playlist_item($item);
                }

                if (!error()) {
                    $eh->flush();
                    e(lang('playlist_items_have_been_removed'), "m");
                } else {
                    $eh->flush();
                    e(lang("playlist_item_doesnt_exist"));
                }
            } else {
                e(lang('no_item_was_selected_to_delete'));
            }
        }

        assign('mode', 'edit_playlist');
        $pid = $_GET['pid'];

        if (isset($_POST['edit_playlist'])) {
            $_POST['playlist_id'] = $pid;
            $cbvid->action->edit_playlist();
        }

        if (isset($_POST['upload_playlist_cover'])) {
            $cover = $_FILES['playlist_cover'];
            $cover['playlist_id'] = $pid;

            if (playlist_upload_cover($cover)) {
                e(lang('Playlist cover has been uploaded'), 'm');
            }

            if (file_exists($cover['tmp_name'])) {
                unlink($cover['tmp_name']);
            }
        }

        //Deleting Item
        if (!empty($_GET['delete_item'])) {
            $delid = mysql_clean($_GET['delete_item']);
            $cbvid->action->delete_playlist_item($delid);
        }

        $playlist = Playlist::getInstance()->getAll([
            'userid'      => user_id(),
            'playlist_id' => $pid,
            'first_only'  => true
        ]);
        if ($playlist) {
            assign('playlist', $playlist);
            //Getting Playlist Item
            $items = $cbvid->get_playlist_items($pid, 'playlist_items.date_added DESC', 0);
            assign('items', $items);
        } else {
            e(lang('playlist_not_exist'));
        }
        break;
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                                => 'admin',
    'pages/manage_playlist/manage_playlist' . $min_suffixe . '.js' => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js'     => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('playlist');
assign('available_tags', $available_tags);

subtitle(lang('manage_playlist'));
template_files('manage_playlists.html');
display_it();
