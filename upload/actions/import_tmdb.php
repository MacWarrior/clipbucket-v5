<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$video_info = Video::getInstance()->getOne([
    'videoid' => $_POST['videoid']
]);
if (empty($video_info)) {
    e(lang('class_vdo_del_err'));
}

$movie_details = Tmdb::getInstance()->movieDetail($_POST['tmdb_video_id']);

$video_info['title'] = $movie_details['title'];
$video_info['description'] = $movie_details['overview'];


//TODO tags

//TODO import poster into custom thumb