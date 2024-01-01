<?php
define('THIS_PAGE', 'weekly_activity_reports');

require_once dirname(__FILE__, 4) . '/includes/admin_config.php';

$days = 10;
$last_week = time() - 86400 * $days + 86400;
$the_last_week = date('M d', $last_week);
$vid_stats = $data['video_stats'];
$vid_stats = json_decode($vid_stats);

//Getting This Weeks Data
$year = [];
for ($i = 0; $i < $days; $i++) {
    if ($i < $days) {
        $date_pattern = date('Y-m-d', $last_week + ($i * 86400));
        $data = Clipbucket_db::getInstance()->select(tbl('stats'), '*', ' date_added LIKE \'%'.$date_pattern.'%\' ', 1);
        $data = $data[0];
        $datas[] = $data;
    }

    $year[] = date('M d', $last_week + ($i * 86400));
}

//Videos
$videos['uploads'] = CBvideo::getInstance()->get_videos(['count_only' => true, 'date_span' => 'this_week'], true);
$videos['processing'] = CBvideo::getInstance()->get_videos(['count_only' => true, 'status' => 'Processing', 'date_span' => 'this_week'], true);
$videos['active'] = CBvideo::getInstance()->get_videos(['count_only' => true, 'active' => 'yes', 'date_span' => 'this_week'], true);
$V = [[lang('uploaded'), $videos['uploads']], [lang('processing'), $videos['processing']], [lang('active'), $videos['active']]];
$array_video = ['label' => lang('videos'), 'data' => $V];

//Users
$users['signups'] = userquery::getInstance()->get_users(['count_only' => true, 'date_span' => 'this_week']);
$users['inactive'] = userquery::getInstance()->get_users(['count_only' => true, 'date_span' => 'this_week', 'status' => 'ToActivate']);
$users['active'] = userquery::getInstance()->get_users(['count_only' => true, 'date_span' => 'this_week', 'status' => 'Ok']);
$U = [[lang('signups'), $users['signups']], [lang('inactive'), $users['inactive']], [lang('active_users'), $users['active']]];
$array_user = ['label' => lang('users'), 'data' => $U];

echo json_encode([$array_user, $array_video]);
