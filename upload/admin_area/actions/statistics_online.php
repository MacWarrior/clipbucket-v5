<?php
const THIS_PAGE = 'statistics_online';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$ongoing_conversion = VideoConversionQueue::getAll(['count' => true, 'not_complete' => true]);
$online_users = userquery::getInstance()->get_online_users();
echo json_encode([
    'html' => '<p>
        ' . lang('ongoing_videos_conversions') . ' : <b>' . $ongoing_conversion . '</b>
    </p>
    <p>
        ' . lang('online_users') . ' :<b>' . count($online_users) . '</b>
    </p> '
]);