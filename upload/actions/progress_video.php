<?php
define('THIS_PAGE', 'progress_video');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$return = [];
$videos = Video::getInstance()->getAll([
    'videoids' => $_POST['ids']
]);
$all_complete = true;
$template = 'blocks/videos/video.html';
switch ($_POST['output']) {
    case 'videos':
    case 'view_channel':
    case 'view_collection':
        $display_type = 'homeVideos';
        break;
    case 'home':
        $display_type = 'ajaxHome';
        break;
    case 'home_featured':
        $display_type = 'featuredHome';
        if (config('featured_video_style') == 'modern') {
            $display_type = '';
            $template = 'blocks/videos/featured_video_slider_block.html';
        }
        break;
    case 'search':
        $display_type = 'normal';
        break;
    case 'user_videos':
    case 'default_slider':
        $display_type = 'user-videos';
        break;
    case 'watch_video':
        $display_type = 'popVideos_sidebar';
        break;
    case 'account':
        $display_type = '';
        $favorites = User::getInstance()->getFavoritesVideos(user_id());
        assign('favorites', $favorites);
        assign('control', 'full');
        $template = 'blocks/manage/account_video.html';
        break;
    default:
        $display_type = '';
        break;
}
assign('display_type', $display_type);
get_fast_qlist();
foreach ($videos as $video) {
    assign('video', $video);
    $data = ['videoid' => $video['videoid'], 'status'=>$video['status']];
    if ($video['status'] !='Successful') {
        $all_complete = false;
        if ($video['status'] == 'Processing') {
            $data['percent'] = $video['convert_percent'];
        }
    }
    $data['html'] = getTemplate($template);
    $return['videos'][] = $data;
}
echo json_encode(['data'=>$return, 'all_complete'=>$all_complete]);
