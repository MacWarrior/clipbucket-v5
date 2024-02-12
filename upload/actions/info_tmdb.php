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
$results= Tmdb::getInstance()->searchMovie($title);
if (!empty($results['error'])) {
    e(lang($results['error']));
}
display_tmdb_result(['results'=>$results['response']['results'], 'title'=>$title], $video_info['videoid']);
