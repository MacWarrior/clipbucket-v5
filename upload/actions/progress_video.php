<?php
const THIS_PAGE = 'progress_video';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$return = [];
$videos = Video::getInstance()->getAll([
    'videoids' => $_POST['ids']
]);
$all_complete = true;

switch ($_POST['output']) {
    case 'home':
        assign('popup_video', config('popup_video') == 'yes');
        if (config('homepage_recent_video_style') == 'modern') {
            assign('width', 270);
            $template = "blocks/videos/video-modern.html";
        } else {
            $template = 'blocks/videos/video-classic.html';
        }
        break;

    case 'view_channel':
        if (config('channel_video_style') == 'modern') {
            $template = "blocks/videos/video-modern.html";
        } else {
            $template = 'blocks/videos/video-classic.html';
        }
        break;

    case 'home_featured':
        $display_type = 'featuredHome';
        assign('popup_video', config('popup_video') == 'yes');
        if (config('featured_video_style') == 'modern') {
            $display_type = '';
            $template = 'blocks/videos/featured_video_slider_block.html';
        } else {
            $template = 'blocks/videos/video-classic.html';
        }
        break;

    case 'home_collection':
        if (config('homepage_collection_video_style') == 'modern') {
            assign('width', 270);
            $template = "blocks/videos/video-modern.html";
        } else {
            $template = 'blocks/videos/video-classic.html';
        }
        break;

    case 'watch_video':
        $display_type = '';
        $template = "blocks/videos/watch_video.html";
        break;

    case 'account':
        $display_type = '';
        $favorites = User::getInstance()->getFavoritesVideos();
        assign('favorites', $favorites);
        assign('control', 'full');
        $template = 'blocks/manage/account_video.html';
        break;

    case 'view_channel_player':
        $get_player = true;
        if (config('channel_video_style') == 'modern') {
            $template = "blocks/videos/video-modern.html";
        } else {
            $template = 'blocks/videos/video-classic.html';
        }
        break;

    default:
        $template = 'blocks/videos/video-classic.html';
        break;
}

if( config('enable_quicklist') == 'yes' && Session::isCookieConsent('fast_qlist') ) {
    get_fast_qlist();
}
foreach ($videos as $video) {
    assign('video', $video);
    $data = ['videoid' => $video['videoid'], 'status'=>$video['status']];
    if ($video['status'] !='Successful') {
        $all_complete = false;
        if ($video['status'] == 'Processing') {
            $data['percent'] = $video['convert_percent'];
        }
    } elseif (!empty($get_player) && $video['videokey'] == userMainVideo($videos)) {
        assign('data', $video);
        ob_start();
        show_player(['vdetails'=>$video]);

        $return['player']['html'] = ob_get_clean();
        $return['player']['id'] = $video['videoid'];
    }
    $data['html'] = getTemplate($template);
    $return['videos'][] = $data;
}
echo json_encode(['data'=>$return, 'all_complete'=>$all_complete]);
