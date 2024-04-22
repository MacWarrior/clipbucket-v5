<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$video_info = Video::getInstance()->getOne([
    'videoid' => $_POST['videoid']
]);
if (empty($video_info)) {
    e(lang('class_vdo_del_err'));
}
Tmdb::getInstance()->deleteOldCacheEntries();
$title = !empty($_POST['video_title']) ? $_POST['video_title'] : $video_info['title'];
$sort = empty($_POST['sort']) ? 'release_date' : $_POST['sort'];
$sort_order = empty($_POST['sort_order']) ? 'DESC' : $_POST['sort_order'];

$total_rows = 0;
$cache_results = Tmdb::getInstance()->getSearchInfo($title);
if (!empty($cache_results)) {
    $total_rows = $cache_results[0]['total_results'];
} else {
    $tmdb_results = [];
    $page_tmdb = 1;
    do {
        $results = Tmdb::getInstance()->searchMovie($title, $page_tmdb)['response'];
        $total_rows = $results['total_results'];
        $tmdb_results = array_merge($tmdb_results, $results['results']);
        $page_tmdb++;
        if (!empty($results['error'])) {
            e(lang($results['error']));
            break;
        }
    } while (!empty($results['results']));

    if (!empty($tmdb_results)) {
        try {
            Tmdb::getInstance()->setQueryInCache($title, $tmdb_results, $total_rows);
        } catch (Exception $e) {
            e($e->getMessage());
        }
    }
}
$final_results = Tmdb::getInstance()->getCacheFromQuery($title, $sort, $sort_order,$_POST['page']);

$total_pages = count_pages($total_rows, config('tmdb_search'));
pages::getInstance()->paginate($total_pages, $_POST['page'], 'javascript:pageInfoTmdb(#page#);');
assign('user_age'  , User::getInstance()->getCurrentUserAge());
display_tmdb_result([
    'results'    => $final_results,
    'title'      => $title,
    'sort'       => $sort,
    'sort_order' => $sort_order
], $video_info['videoid']);
