<?php
error_reporting(E_ALL);
require_once('../../../../includes/admin_config.php');

$flaggedVideos['today'] = $cbvid->get_videos(["count_only" => true, "flagged" => "yes", "data_span" => "today"], true);
$flaggedVideos['this_week'] = $cbvid->get_videos(["count_only" => true, "flagged" => "yes", "data_span" => "this_week"], true);
$flaggedVideos['this_month'] = $cbvid->get_videos(["count_only" => true, "flagged" => "yes", "data_span" => "this_month"], true);

$flaggedUsers['today'] = $userquery->get_users(["count_only" => true, "flagged" => "yes", "data_span" => "today"], true);
$flaggedUsers['this_week'] = $userquery->get_users(["count_only" => true, "flagged" => "yes", "data_span" => "this_week"], true);
$flaggedUsers['this_month'] = $userquery->get_users(["count_only" => true, "flagged" => "yes", "data_span" => "this_month"], true);

$flaggedPhotos['today'] = $cbphoto->get_photos(["count_only" => true, "flagged" => "yes", "data_span" => "today"], true);
$flaggedPhotos['this_week'] = $cbphoto->get_photos(["count_only" => true, "flagged" => "yes", "data_span" => "this_week"], true);
$flaggedPhotos['this_month'] = $cbphoto->get_photos(["count_only" => true, "flagged" => "yes", "data_span" => "this_month"], true);


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