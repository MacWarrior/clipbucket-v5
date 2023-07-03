<?php
global $db, $cbvid, $userquery;

/**
 * This class is used to update clipbucket daily stats
 */

$in_bg_cron = true;

//including config file..
include(dirname(__FILE__) . "/../includes/config.inc.php");

//Calling Cron Functions
cb_call_functions('update_cb_stats_cron');


//Now Gathering All Data
$date = date('Y-m-d H:i:s');

//Videos
$videos['uploads'] = $cbvid->get_videos(['count_only' => true, 'date_span' => 'today'], true);
$videos['processing'] = $cbvid->get_videos(['count_only' => true, 'status' => 'Processing', 'date_span' => 'today'], true);
$videos['active'] = $cbvid->get_videos(['count_only' => true, 'active' => 'yes', 'date_span' => 'today'], true);
//Views
$vid_views = $db->select(tbl('video'), 'SUM(views) as total_views', " date_added LIKE '%$date%'");
$videos['views'] = $vid_views[0]['total_views'];
//Total Comments
$vid_comments = $db->select(tbl('video'), 'SUM(comments_count) as total_comments', " date_added LIKE '%$date%'");
$videos['comments'] = $vid_comments[0]['total_comments'];

//Users
$users['signups'] = $userquery->get_users(['count_only' => true, 'date_span' => 'today']);
$users['inactive'] = $userquery->get_users(['count_only' => true, 'date_span' => 'today', 'status' => 'ToActivate']);
$users['active'] = $userquery->get_users(['count_only' => true, 'date_span' => 'today', 'status' => 'Ok']);
//Views
$user_views = $db->select(tbl('users'), 'SUM(profile_hits) as total_views', " doj LIKE '%$date%'");
$users['views'] = $user_views[0]['total_views'];
//Total Comments
$user_comments = $db->select(tbl('users'), 'SUM(comments_count) as total_comments', " doj LIKE '%$date%'");
$users['comments'] = $user_comments[0]['total_comments'];

$video = '[';
foreach ($videos as $key => $value) {
    $video .= '["' . $key . '","' . $value . '"],';
}
$video .= ']';

$user = '[';
foreach ($users as $key => $value) {
    $user .= '["' . $key . '","' . $value . '"],';
}
$user .= ']';

$fields = ['video_stats', 'user_stats'];

$values = ['|no_mc|' . json_encode($videos), '|no_mc|' . json_encode($users)];

pr($values, true);
//Checking If there is already a row of the same date, then update it otherwise insert data
$result = $db->select(tbl('stats'), 'stat_id', " date_added LIKE '%$date%'");
if (count($result) > 0) {
    $result = $result[0];
    $db->update(tbl('stats'), $fields, $values, " stat_id='" . $result['stat_id'] . "'");
} else {
    $fields[] = 'date_added';
    $values[] = $date;
    $db->insert(tbl('stats'), $fields, $values);
}
