<?php
const THIS_PAGE = 'activity_reports';

require_once dirname(__FILE__, 4) . '/includes/admin_config.php';

if (!in_array($_POST['span'], ['today', 'week', 'month'])) {
    echo json_encode([[],[]]);
    die;
}
if (config('videosSection') == 'yes') {
    $videos['uploads'] = Video::getInstance()->getAll(['count' => true, 'date_span' => $_POST['span']]);
    $videos['processing'] = Video::getInstance()->getAll(['count' => true, 'date_span' => $_POST['span'], 'status' => 'Processing']);
    $videos['active'] = Video::getInstance()->getAll(['count' => true, 'date_span' => $_POST['span'], 'active' => 'yes']);
//Videos
    $array_video = [
        'label' => lang('videos'),
        'data'  => [
            [lang('uploaded'), $videos['uploads']],
            [lang('processing'), $videos['processing']],
            [lang('active'), $videos['active']]
        ]
    ];
}

//Users
$users['signups'] = userquery::getInstance()->get_users(['count_only' => true, 'date_span' => $_POST['span']]);
$users['inactive'] = userquery::getInstance()->get_users(['count_only' => true, 'date_span' => $_POST['span'], 'status' => 'ToActivate']);
$users['active'] = userquery::getInstance()->get_users(['count_only' => true, 'date_span' => $_POST['span'], 'status' => 'Ok']);
$U = [[lang('signups'), $users['signups']], [lang('inactive'), $users['inactive']], [lang('active_users'), $users['active']]];
$array_user = ['label' => lang('users'), 'data' => $U];

echo json_encode([$array_user, $array_video ?? []]);
