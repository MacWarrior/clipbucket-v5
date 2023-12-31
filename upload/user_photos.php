<?php
define('THIS_PAGE', 'user_photos');
define('PARENT_PAGE', 'photos');

global $pages,$userquery,$cbphoto;

require 'includes/config.inc.php';
$pages->page_redir();

$u = $_GET['user'];
$u = $u ? $u : $_GET['userid'];
$u = $u ? $u : $_GET['username'];
$u = $u ? $u : $_GET['uid'];
$u = $u ? $u : $_GET['u'];

$user = $userquery->get_user_details($u);
$page = mysql_clean($_GET['page']);

if ($user) {
    assign('u', $user);
    assign('p', $userquery->get_user_profile($udetails['userid']));

    $mode = $_GET['mode'];

    switch ($mode) {
        case 'photos':
        case 'uploaded':
        default:
            $limit = create_query_limit($page, config('photo_user_photos'));
            assign("the_title", $user['username'] . ' ' . lang('photos'));
            $photos = get_photos(["limit" => $limit, "user" => $user['userid']]);
            $total_rows = get_photos(["count_only" => true, "user" => $user['userid']]);
            $total_pages = count_pages($total_rows, config('photo_user_photos'));
            break;

        case 'favorites':
        case 'fav_photos':
        case 'favorite':
            $limit = create_query_limit($page, config('photo_user_favorites'));
            assign('the_title', $user['username'] . " " . lang('Favorite') . " " . lang('photos'));
            $favP = ['user' => $user['userid'], 'limit', $limit];
            $photos = $cbphoto->action->get_favorites($favP);
            $favP['count_only'] = true;
            $total_rows = $cbphoto->action->get_favorites($favP);
            $total_pages = count_pages($total_rows, config('photo_user_favorites'));
            break;
    }

    assign('photos', $photos);

    $pages->paginate($total_pages, $page);
} else {
    e(lang('usr_exist_err'));
    ClipBucket::getInstance()->show_page = false;
}

if (ClipBucket::getInstance()->show_page) {
    Template('user_photos.html');
} else {
    display_it();
}
