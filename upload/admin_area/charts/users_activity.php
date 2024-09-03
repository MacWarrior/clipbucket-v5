<?php
include '../../includes/admin_config.php';

$days = 7;
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

pr($datas, true);
for ($i = 0; $i < $days; $i++) {
    $day[$i]['video'] = json_decode($datas[$i]['video_stats'], true);
    $day[$i]['users'] = json_decode($datas[$i]['user_stats'], true);
}
$max = 1;
for ($i = 0; $i < $days; $i++) {
    if ($i == $days - 1) {
        $signups[] = $userquery->get_users(["count_only" => true, "date_span" => "today"]) + 0;
        $active[] = $userquery->get_users(["count_only" => true, "date_span" => "today", "status" => 'Ok']) + 0;
        $inactive[] = $userquery->get_users(["count_only" => true, "date_span" => "today", "status" => 'ToActivate']) + 0;
    } else {
        $signups[] = $day[$i]['users']->signups + 0;
        $active[] = $day[$i]['users']->active + 0;
        $inactive[] = $day[$i]['users']->inactive + 0;
    }
    $max = max($max, $uploads[$i], $inactive[$i], $active[$i]);
}
