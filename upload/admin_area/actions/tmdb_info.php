<?php
const THIS_PAGE = 'admin_info_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!User::getInstance()->hasAdminAccess()) {
    return false;
}

if (config('enable_tmdb') != 'yes' || config('tmdb_token') == '') {
    return false;
}

$results = Tmdb::getInstance()->getInfoTmdb($_POST['videoid'] ?? 0, ($_POST['type'] ?? 'movie'), [
    'video_title' => $_POST['video_title'],
    'sort'        => $_POST['sort'],
    'sort_order'  => $_POST['sort_order'],
    'year'        => $_POST['selected_year'] ?? ''
], $_POST['file_name'] ?? '');

pages::getInstance()->paginate($results['total_pages'], $_POST['page'], 'javascript:pageInfoTmdb(#page#);');
assign('user_age', User::getInstance()->getCurrentUserAge());
assign('can_search_year', Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '106'));
display_tmdb_result([
    'results'       => $results['final_results'],
    'title'         => $results['title'],
    'sort'          => $results['sort'],
    'sort_order'    => $results['sort_order'],
    'years'         => $results['years'],
    'selected_year' => $_POST['selected_year'],
    'type'          => $_POST['type'],
], $results['videoid']);
