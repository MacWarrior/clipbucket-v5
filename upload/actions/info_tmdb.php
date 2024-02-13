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
if (!empty($_POST['sort']) && !empty($_POST['sort_order'])) {
    usort($results['response']['results'], function ($a, $b) {
        if ($_POST['sort_order'] == 'ASC') {
            return $a[$_POST['sort']] <=> $b[$_POST['sort']];
        } else {
            return $b[$_POST['sort']] <=> $a[$_POST['sort']];
        }
    });
}
display_tmdb_result([
        'results'    => $results['response']['results'],
        'title'      => $title,
        'sort'       => $_POST['sort'],
        'sort_order' => $_POST['sort_order']
    ], $video_info['videoid']);
