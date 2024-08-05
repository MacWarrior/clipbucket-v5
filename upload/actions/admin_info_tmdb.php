<?php
define('THIS_PAGE', 'admin_info_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$results = Tmdb::getInstance()->getInfoTmdb($_POST['videoid'] ?? 0, [
    'video_title' => $_POST['video_title'],
    'sort'        => $_POST['sort'],
    'sort_order'  => $_POST['sort_order'],
]);

pages::getInstance()->paginate($results['total_pages'], $_POST['page'], 'javascript:pageInfoTmdb(#page#);');
assign('user_age'  , User::getInstance()->getCurrentUserAge());
display_tmdb_result([
    'results'    => $results['final_results'],
    'title'      => $results['title'],
    'sort'       => $results['sort'],
    'sort_order' => $results['sort_order']
], $results['videoid']);
