<?php
define('THIS_PAGE', 'info_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (config('tmdb_enable_on_front_end') != 'yes' || config('enable_tmdb') != 'yes' || config('tmdb_token') == '') {
    return false;
}

$results = Tmdb::getInstance()->getInfoTmdb($_POST['videoid'], [
    'video_title' => $_POST['video_title'],
    'sort'        => $_POST['sort'],
    'sort_order'  => $_POST['sort_order'],
], $_POST['file_name'] ?? '');

pages::getInstance()->paginate($results['total_pages'], $_POST['page'], 'javascript:pageInfoTmdb(#page#, '.$results['videoid'].');');

assign('user_age'  , User::getInstance()->getCurrentUserAge());
display_tmdb_result([
    'results'    => $results['final_results'],
    'title'      => $results['title'],
    'sort'       => $results['sort'],
    'sort_order' => $results['sort_order'],
    'videoid'     => $results['videoid'],
], $results['videoid']);
