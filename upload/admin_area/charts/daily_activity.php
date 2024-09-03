<?php
error_reporting(E_ALL);
require_once('../../includes/admin_config.php');
global $cbvid, $userquery;

$days = 10;
$last_week = time() - 86400 * $days + 86400;
$the_last_week = date('M d', $last_week);

$vid_stats = $data['video_stats'];
$vid_stats = json_decode($vid_stats);

$year = [];

//Getting This Weeks Data
for ($i = 0; $i < $days; $i++) {
    if ($i < $days) {
        $date_pattern = date("Y-m-d", $last_week + ($i * 86400));

        $data = Clipbucket_db::getInstance()->select(tbl("stats"), "*", " date_added LIKE '%$date_pattern%' ", 1);
        $data = $data[0];

        $datas[] = $data;
    }

    $year[] = date("M d", $last_week + ($i * 86400));
}
//Videos
echo $_post['videos'];

//Getting the data for Flot Charts

//videos
$videos['uploads'] = $cbvid->get_videos(["count_only" => true, "date_added" => "'%$date_pattern%'"], true);
$videos['processing'] = $cbvid->get_videos(["count_only" => true, "status" => "Processing", "date_added" => "'%$date_pattern%'"], true);
$videos['active'] = $cbvid->get_videos(["count_only" => true, "active" => "yes", "date_added" => "'%$date_pattern%'"], true);
$V = [['uploads', $videos['uploads']], ['processing', $videos['processing']], ['active', $videos['active']]];

//Users
$users['signups'] = $userquery->get_users(["count_only" => true, "date_added" => "'%$date_pattern%'"]);
$users['inactive'] = $userquery->get_users(["count_only" => true, "date_added" => "'%$date_pattern%'", "status" => 'ToActivate']);
$users['active'] = $userquery->get_users(["count_only" => true, "date_added" => "'%$date_pattern%'", "status" => 'Ok']);
//Views
$user_views = Clipbucket_db::getInstance()->select(tbl("users"), "SUM(profile_hits) as total_views", " doj LIKE '%$date_pattern%'");
$users['views'] = $user_views[0]['total_views'];
//Total Comments
$user_comments = Clipbucket_db::getInstance()->select(tbl("users"), "SUM(comments_count) as total_comments", " doj LIKE '%$date_pattern%'");
$users['comments'] = $user_comments[0]['total_comments'];

$U = [['signups', $users['signups']], ['inactive', $users['inactive']], ['Active User', $users['active']], ['views User', $users['views']], ['comments User', $users['comments']]];

//Make arrays for json
$array_video = ['label' => 'Videos', 'data' => $V];
$array_user = ['label' => 'Users', 'data' => $U];

echo json_encode([$array_user, $array_video]);

for ($i = 0; $i < $days; $i++) {
    $day[$i]['video'] = json_decode($datas[$i]['video_stats']);
    $day[$i]['users'] = json_decode($datas[$i]['user_stats']);
}

$max = 1;
for ($i = 0; $i < $days; $i++) {
    if ($i == $days) {
        $vid_uploads[] = $cbvid->get_videos(["count_only" => true, "date_span" => "today"]) + 0;
        $user_signups[] = $userquery->get_users(["count_only" => true, "date_span" => "today"]) + 0;
    } else {
        $vid_uploads[] = $day[$i]['video']->uploads + 0;
        $user_signups[] = $day[$i]['users']->signups + 0;
    }
    $max = max($max, $vid_uploads[$i], $user_signups[$i]);
}

$steps = round($max / 5, 0.49);
