<?php
define('THIS_PAGE', 'admin_progress_video');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
$return = [];
$params= ['videoids' => $_POST['ids']];
if (config('enable_video_categories') !='no') {
    $params['get_detail']=true;
}
$videos = Video::getInstance()->getAll($params);
$all_complete = true;
foreach ($videos as $video) {
    assign('video', $video);
    if ($video['status'] !='Successful') {
        $all_complete = false;
    }
    $data = ['videoid' => $video['videoid']];
    if ($_POST['output'] == 'line') {
        $data['html'] = getTemplate('blocks/video_manager_line.html');
    } elseif ($_POST['output'] == 'edit') {
        assign('data', $video);
        $data['html'] = getTemplate('blocks/video_player.html');
        $data['data'] = $video;
    }
    $return['videos'][] = $data;
}
echo json_encode(['data'=>$return, 'all_complete'=>$all_complete]);
