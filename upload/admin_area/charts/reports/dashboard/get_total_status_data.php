<?php

error_reporting(E_ALL);
require_once('../../../../includes/admin_config.php');

$totalVideos['today'] = $cbvid->get_videos(["count_only" => true, "data_span" => "today"], true);
$totalVideos['this_week'] = $cbvid->get_videos(["count_only" => true, "data_span" => "this_week"], true);
$totalVideos['this_month'] = $cbvid->get_videos(["count_only" => true, "data_span" => "this_month"], true);

$totalUsers['today'] = $userquery->get_users(["count_only" => true, "data_span" => "today"], true);
$totalUsers['this_week'] = $userquery->get_users(["count_only" => true, "data_span" => "this_week"], true);
$totalUsers['this_month'] = $userquery->get_users(["count_only" => true, "data_span" => "this_month"], true);

$totalPhotos['today'] = $cbphoto->get_photos(["count_only" => true, "data_span" => "today"], true);
$totalPhotos['this_week'] = $cbphoto->get_photos(["count_only" => true, "data_span" => "this_week"], true);
$totalPhotos['this_month'] = $cbphoto->get_photos(["count_only" => true, "data_span" => "this_month"], true);


$todayStats = [
    "label" => "Today Stats",
    "data"  => [
        ['users', $totalUsers['today']],
        ['photos', $totalPhotos['today']],
        ['videos', $totalVideos['today']],
    ]
];

$weekStats = [
    "label" => "Week Stats",
    "data"  => [
        ['users', $totalUsers['this_week']],
        ['photos', $totalPhotos['this_week']],
        ['videos', $totalVideos['this_week']],
    ]
];


$monthStats = [
    "label" => "Month Stats",
    "data"  => [
        ['users', $totalUsers['this_month']],
        ['photos', $totalPhotos['this_month']],
        ['videos', $totalVideos['this_month']],
    ]
];

$data = [
    "today"      => $todayStats,
    "this_week"  => $weekStats,
    "this_month" => $monthStats,
];

echo json_encode($data);