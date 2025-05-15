<?php
error_reporting(E_ALL);
require_once('../../../../includes/admin_config.php');

$flaggedVideos['today'] = CBvideo::getInstance()->get_videos(["count_only" => true, "flagged" => "yes", "data_span" => "today"], true);
$flaggedVideos['this_week'] = CBvideo::getInstance()->get_videos(["count_only" => true, "flagged" => "yes", "data_span" => "this_week"], true);
$flaggedVideos['this_month'] = CBvideo::getInstance()->get_videos(["count_only" => true, "flagged" => "yes", "data_span" => "this_month"], true);

$flaggedUsers['today'] = userquery::getInstance()->get_users(["count_only" => true, "flagged" => "yes", "data_span" => "today"], true);
$flaggedUsers['this_week'] = userquery::getInstance()->get_users(["count_only" => true, "flagged" => "yes", "data_span" => "this_week"], true);
$flaggedUsers['this_month'] = userquery::getInstance()->get_users(["count_only" => true, "flagged" => "yes", "data_span" => "this_month"], true);

$flaggedPhotos['today'] = CBPhotos::getInstance()->get_photos(["count_only" => true, "flagged" => "yes", "data_span" => "today"], true);
$flaggedPhotos['this_week'] = CBPhotos::getInstance()->get_photos(["count_only" => true, "flagged" => "yes", "data_span" => "this_week"], true);
$flaggedPhotos['this_month'] = CBPhotos::getInstance()->get_photos(["count_only" => true, "flagged" => "yes", "data_span" => "this_month"], true);


$flaggedTodayStats = [
    "label" => "Today flagged objects",
    "data"  => [
        ['users', $flaggedUsers['today']],
        ['photos', $flaggedPhotos['today']],
        ['videos', $flaggedVideos['today']],
    ]
];

$flaggedWeekStats = [
    "label" => "Week flagged objects",
    "data"  => [
        ['users', $flaggedUsers['this_week']],
        ['photos', $flaggedPhotos['this_week']],
        ['videos', $flaggedVideos['this_week']],
    ]
];


$flaggedMonthStats = [
    "label" => "Month flagged objects",
    "data"  => [
        ['users', $flaggedUsers['this_month']],
        ['photos', $flaggedPhotos['this_month']],
        ['videos', $flaggedVideos['this_month']],
    ]
];

$data = [
    "today"      => $flaggedTodayStats,
    "this_week"  => $flaggedWeekStats,
    "this_month" => $flaggedMonthStats,
];

echo json_encode($data);