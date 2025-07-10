<?php
define('THIS_PAGE', 'admin_progress_video');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$return = [];

$queue_list = myquery::getInstance()->get_conversion_queue(' cqueue_id IN (' . implode(',', $_POST['ids']) . ')');
$all_complete = true;
foreach ($queue_list as $queue) {
    $params = ['file_name' => $queue['cqueue_name']];
    if (config('enable_video_categories') != 'no') {
        $params['get_detail'] = true;
    }
    $video = Video::getInstance()->getOne($params);
    assign('video', $video);
    assign('queue', $queue);
    if ($video['status'] != 'Successful') {
        $all_complete = false;
    }
    $data = ['cqueue_id' => $queue['cqueue_id']];
    $data['html'] = getTemplate('blocks/cb_conversion_queue_line.html');
    $return['cqueues'][] = $data;
}
echo json_encode(['data'         => $return,
                  'all_complete' => $all_complete
]);
