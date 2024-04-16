<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (config('tmdb_enable_on_front_end') !== 'yes') {
    return false;
}

$results = Tmdb::getInstance()->getInfoTmdb($_POST['videoid'], [
    'video_title' => $_POST['video_title'],
    'sort'        => $_POST['sort'],
    'sort_order'  => $_POST['sort_order'],
], $_POST['file_name'] ?? '');

pages::getInstance()->paginate($results['total_pages'], $_POST['page'], 'javascript:pageInfoTmdb(#page#, '.$results['videoid'].');');

display_tmdb_result([
    'results'    => $results['final_results'],
    'title'      => $results['title'],
    'sort'       => $results['sort'],
    'sort_order' => $results['sort_order'],
    'videoid'     => $results['videoid'],
], $results['videoid']);
