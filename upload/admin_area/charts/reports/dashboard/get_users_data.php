<?php

error_reporting(E_ALL);
require_once('../../../../includes/admin_config.php');

$todayUsers['signups'] = $userquery->get_users(["count_only" => true, "date_span" => "today"]);
$todayUsers['inactive'] = $userquery->get_users(["count_only" => true, "date_span" => "today", "status" => 'ToActivate']);
$todayUsers['active'] = $userquery->get_users(["count_only" => true, "date_span" => "today", "status" => 'Ok']);

$userTodayStats = [
    "label" => "User Today Stats",
    "data"  => [
        ['signups', $todayUsers['signups']],
        ['inactive', $todayUsers['inactive']],
        ['active', $todayUsers['active']],
    ]
];


$weekUsers['signups'] = $userquery->get_users(["count_only" => true, "date_span" => "this_week"]);
$weekUsers['inactive'] = $userquery->get_users(["count_only" => true, "date_span" => "this_week", "status" => 'ToActivate']);
$weekUsers['active'] = $userquery->get_users(["count_only" => true, "date_span" => "this_week", "status" => 'Ok']);

$userWeekStats = [
    "label" => "User month Stats",
    "data"  => [
        ['signups', $weekUsers['signups']],
        ['inactive', $weekUsers['inactive']],
        ['active', $weekUsers['active']]
    ],
];


$monthUsers['signups'] = $userquery->get_users(["count_only" => true, "date_span" => "this_month"]);
$monthUsers['inactive'] = $userquery->get_users(["count_only" => true, "date_span" => "this_month", "status" => 'ToActivate']);
$monthUsers['active'] = $userquery->get_users(["count_only" => true, "date_span" => "this_month", "status" => 'Ok']);

$userMonthStats = [
    "label" => "User month Stats",
    "data"  => [
        ['signups', $monthUsers['signups']],
        ['inactive', $monthUsers['inactive']],
        ['active', $monthUsers['active']]
    ],
];


$data = [
    "today"      => $userTodayStats,
    "this_week"  => $userWeekStats,
    "this_month" => $userMonthStats,
];

echo json_encode($data);