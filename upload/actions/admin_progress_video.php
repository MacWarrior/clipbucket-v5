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
    $data = ['videoid' => $video['videoid']];
    if ($_POST['output'] == 'html') {
        $data['html'] = getTemplate('blocks/video_manager_line.html');
    } elseif ($_POST['output'] == 'percent') {
        $data['percent'] = $video['convert_percent'];
    }
    $return['videos'][] = $data;
}
if ($all_complete && $_POST['output'] == 'percent') {
    ob_start();
    show_player(['vdetails'=> $video]);
    $html = ob_get_clean();
    $return['html'] = $html;
}
echo json_encode(['data'=>$return, 'all_complete'=>$all_complete]);
