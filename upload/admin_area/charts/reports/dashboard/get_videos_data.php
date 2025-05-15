<?php

error_reporting(E_ALL);
require_once('../../../../includes/admin_config.php');

$todayVideos['uploads'] = CBvideo::getInstance()->get_videos(["count_only" => true, "date_span" => "today"], true);
$todayVideos['processing'] = CBvideo::getInstance()->get_videos(["count_only" => true, "status" => "Processing", "date_span" => "today"], true);
$todayVideos['active'] = CBvideo::getInstance()->get_videos(["count_only" => true, "active" => "yes", "date_span" => "today"], true);

$videoTodayStats = [
    "label" => "User Today Stats",
    "data"  => [
        ['uploads', $todayVideos['uploads']],
        ['processing', $todayVideos['processing']],
        ['active', $todayVideos['active']],
    ]
];


$weekVideos['uploads'] = CBvideo::getInstance()->get_videos(["count_only" => true, "date_span" => "this_week"], true);
$weekVideos['processing'] = CBvideo::getInstance()->get_videos(["count_only" => true, "status" => "Processing", "date_span" => "this_week"], true);
$weekVideos['active'] = CBvideo::getInstance()->get_videos(["count_only" => true, "active" => "yes", "date_span" => "this_week"], true);

$videoWeekStats = [
    "label" => "User month Stats",
    "data"  => [
        ['uploads', $weekVideos['uploads']],
        ['processing', $weekVideos['processing']],
        ['active', $weekVideos['active']]
    ],
];


$monthVideos['uploads'] = CBvideo::getInstance()->get_videos(["count_only" => true, "date_span" => "this_month"], true);
$monthVideos['processing'] = CBvideo::getInstance()->get_videos(["count_only" => true, "status" => "Processing", "date_span" => "this_month"], true);
$monthVideos['active'] = CBvideo::getInstance()->get_videos(["count_only" => true, "active" => "yes", "date_span" => "this_month"], true);

$videoMonthStats = [
    "label" => "User month Stats",
    "data"  => [
        ['uploads', $monthVideos['uploads']],
        ['processing', $monthVideos['processing']],
        ['active', $monthVideos['active']]
    ],
];


$data = [
    "today"      => $videoTodayStats,
    "this_week"  => $videoWeekStats,
    "this_month" => $videoMonthStats,
];

echo json_encode($data);