<?php
define('THIS_PAGE', 'myaccount');
define('PARENT_PAGE', 'home');

require 'includes/config.inc.php';
global $db, $cbvid, $userquery, $cbphoto, $cbvideo;
$userquery->logincheck();

assign('user', $userquery->get_user_details(user_id()));
$videos = $userquery->get_user_vids(user_id(), false, false, true);
assign('videos', $videos);

$result_array['limit'] = $get_limit;
$result_array['user'] = $udetails["userid"];
$get_limit = create_query_limit($page, 5);
$videos = $cbvid->action->get_flagged_objects($get_limit);
Assign('flagedVideos', $videos);
Assign('count_flagged_videos', $cbvid->action->count_flagged_objects());

$result_array['limit'] = $get_limit;
$result_array['user'] = $udetails["userid"];
$get_limit = create_query_limit($page, 5);
$photos = $cbphoto->action->get_flagged_objects($get_limit);
assign('flagedPhotos', $photos);
Assign('count_flagged_photos', $cbphoto->action->count_flagged_objects());

if (isset($_GET['delete_video'])) {
    $video = mysql_clean($_GET['delete_video']);
    $cbvideo->delete_video($video);
}

subtitle(lang('my_account'));
template_files('myaccount.html');
display_it();
