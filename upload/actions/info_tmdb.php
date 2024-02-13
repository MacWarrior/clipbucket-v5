<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$video_info = Video::getInstance()->getOne([
    'videoid' => $_POST['videoid']
]);
if (empty($video_info)) {
    e(lang('class_vdo_del_err'));
}
$title = !empty($_POST['video_title']) ? $_POST['video_title'] : $video_info['title'];
$results = Tmdb::getInstance()->searchMovie($title);
if (!empty($results['error'])) {
    e(lang($results['error']));
}

$sort = empty($_POST['sort']) ? 'release_date' : $_POST['sort'];
$sort_order = empty($_POST['sort_order']) ? 'ASC' : $_POST['sort_order'];
    usort($results['response']['results'], function ($a, $b) use ($sort, $sort_order) {
        if ($sort_order == 'ASC') {
            return $a[$sort] <=> $b[$sort];
        } else {
            return $b[$sort] <=> $a[$sort];
        }
    });
display_tmdb_result([
        'results'    => $results['response']['results'],
        'title'      => $title,
        'sort'       => $sort,
        'sort_order' => $sort_order
    ], $video_info['videoid']);
