<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$video_info = Video::getInstance()->getOne([
   'videoid' => $_POST['videoid']
]);
if (empty($video_info)) {
    e(lang('class_vdo_del_err'));
}
$results = Tmdb::getInstance()->searchMovie($video_info['title']);
if (!empty($results['error'])) {
    e(lang($results['error']));
}
display_tmdb_result($results['response']['results']);