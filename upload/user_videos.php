<?php
define('THIS_PAGE', 'user_videos');
define('PARENT_PAGE', 'videos');

require 'includes/config.inc.php';
$pages->page_redir();
$userquery->perm_check('view_videos', true);

$u = $_GET['user'];
$u = $u ? $u : $_GET['userid'];
$u = $u ? $u : $_GET['username'];
$u = $u ? $u : $_GET['uid'];
$u = $u ? $u : $_GET['u'];
$u = mysql_clean($u);
$udetails = $userquery->get_user_details($u);
$page = mysql_clean($_GET['page']);

if ($udetails) {
    assign("u", $udetails);
    $mode = $_GET['mode'];

    assign("u", $udetails);
    assign('p', $userquery->get_user_profile($udetails['userid']));

    switch ($mode) {
        case 'uploads':
        case 'videos':
        default:
            $get_limit = create_query_limit($page, config('videos_items_uvid_page'));
            assign("the_title", $udetails['username'] . " videos");
            $videos = get_videos(['user' => $udetails['userid'], 'limit' => $get_limit]);
            $total_rows = get_videos(['user' => $udetails['userid'], 'count_only' => true]);
            subtitle(lang("users_videos", $udetails['username']));
            $total_pages = count_pages($total_rows, config('videos_items_uvid_page'));
            break;

        case 'favorites':
            $get_limit = create_query_limit($page, config('videos_items_ufav_page'));
            assign("the_title", $udetails['username'] . " favorites");
            $params = ['userid' => $udetails['userid'], 'limit' => $get_limit];
            $videos = $cbvid->action->get_favorites($params);
            $params['count_only'] = "yes";
            $total_rows = $cbvid->action->get_favorites($params);
            subtitle(lang("title_usr_fav_vids", $udetails['username']));
            $total_pages = count_pages($total_rows, config('videos_items_ufav_page'));
            break;

        case 'playlists':
            $get_limit = create_query_limit($page, 10);
            $params = ['userid' => $udetails['userid'], 'limit' => $get_limit];
            $playlists = Playlist::getInstance()->getAll($params);
            assign('playlist_mode', 'on');
            assign('playlists', $playlists);
            $params['count_only'] = true;
            $total_rows = Playlist::getInstance()->getAll($params);
            $total_pages = count_pages($total_rows, config('videos_items_ufav_page'));
            break;
    }

    Assign('videos', $videos);

    //Pagination
    $pages->paginate($total_pages, $page);
} else {
    e(lang("usr_exist_err"));
    $Cbucket->show_page = false;
}

if ($Cbucket->show_page) {
    Template('user_videos.html');
} else {
    display_it();
}
