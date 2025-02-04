<?php
define('THIS_PAGE', 'admin_progress_video');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$return = [];
$videos = Video::getInstance()->getAll([
    'videoids' => $_POST['ids']
]);
$all_complete = true;
foreach ($videos as $video) {
    assign('video', $video);
    if ($video['status'] !='Successful') {
        $all_complete = false;
    }
    $return[] = [
        'videoid' => $video['videoid'],
        'html'    => getTemplate('blocks/video_manager_line.html')
    ];
}
echo json_encode(['data'=>$return, 'all_complete'=>$all_complete]);
