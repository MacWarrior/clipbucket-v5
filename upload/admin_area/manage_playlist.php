<?php
define('THIS_PAGE', 'manage_playlists');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $cbvid, $eh, $Cbucket;

userquery::getInstance()->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('videos'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_playlists'),
    'url'   => DirPath::getUrl('admin_area') . 'manage_playlist.php'
];

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

                if (!error()) {
                    $eh->flush();
                    e(lang('playlists_have_been_removed'), 'm');
                } else {
                    $eh->flush();
                    e(lang('playlist_not_exist'));
                }
            } else {
                e(lang('no_playlist_was_selected_to_delete'));
            }

        }

        //if search is activated
        if (isset($_GET['search'])) {
            if (!empty($_GET['playlist_name'])) {
                $array['playlist_name'] = $_GET['playlist_name'];
            }
            if (!empty($_GET['tags'])) {
                $array['tags'] = $_GET['tags'];
            }
            if (!empty($_GET['userid'])) {
                $array['userid'] = $_GET['userid'];
            }
        }

        assign('mode', 'manage_playlist');

        //getting limit for pagination
        $page = mysql_clean($_GET['page']);
        $get_limit = create_query_limit($page, config('admin_pages'));

        //Getting List of available playlists with pagination
        $result_array = $array;
        $result_array['limit'] = $get_limit;
        if (!$array['order']) {
            $result_array['order'] = ' playlists.date_added DESC ';
        }
        $playlists = Playlist::getInstance()->getAll($result_array);

        //Collecting Data for Pagination
        $pcount = $array;
        $pcount['count'] = true;
        $total_rows = Playlist::getInstance()->getAll($pcount);
        $total_pages = count_pages($total_rows, config('admin_pages'));
        $pages->paginate($total_pages, $page);

        assign('playlists', $playlists);
        break;

    case 'edit_playlist':
        if (isset($_POST['delete_playlist_item'])) {
            $items = post('check_playlist_items');

            if (!empty($items)) {
                foreach ($items as $item) {
                    $item = mysql_clean($item);
                    $cbvid->action->delete_playlist_item($item);
                }

                if (!error()) {
                    $eh->flush();
                    e(lang('playlist_items_have_been_removed'), 'm');
                } else {
                    $eh->flush();
                    e(lang('playlist_item_doesnt_exist'));
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

        $playlist = Playlist::getInstance()->getOne($pid);
        if ($playlist) {
            assign('playlist', $playlist);
            //Getting Playlist Item
            $items = $cbvid->get_playlist_items($pid, 'playlist_items.date_added DESC', 0);
            assign('items', $items);
            $breadcrumb[2] = [
                'title' => lang('edit_playlist') . ' ' . display_clean($playlist['playlist_name']) ,
                'url'   => DirPath::getUrl('admin_area') . 'manage_playlist.php?mode=edit_playlist&pid=' . display_clean($pid)
            ];
        } else {
            sessionMessageHandler::add_message(lang('playlist_not_exist'), 'e',  BASEURL . DirPath::getUrl('admin_area') . 'manage_playlist.php');
        }
        break;
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin'
    ,'advanced_search/advanced_search' . $min_suffixe . '.js'   => 'admin'
    ,'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
    ,'jquery-ui-1.13.2.min.js' => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('playlist');
assign('available_tags',$available_tags);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
//- manage play front end
template_files('manage_playlist.html');
display_it();
