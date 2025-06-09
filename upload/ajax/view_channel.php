<?php
define('THIS_PAGE', 'ajax');
require '../includes/config.inc.php';

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];

    switch ($mode) {
        case 'channelMore':
            $load_hit = $_POST['loadHit'];
            $load_limit = $_POST['loadLimit'];
            $user = $_POST['userid'];
            $start = $load_limit * $load_hit - $load_limit;
            $sql_limit = "$start, $load_limit";
            $total_items = $_POST['totalVids'];

            $params = [
                'userid' => $user
                ,'order' => 'date_added DESC'
                ,'limit' => $sql_limit
            ];
            $items = Video::getInstance()->getAll($params);

            if ($start >= $total_items) {
                return false;
            }
            $ids_to_check_progress = [];
            $video_blocks = [];
            foreach ($items as $key => $video) {
                assign('video', $video);

                if( config('enable_quicklist') == 'yes' && Session::isCookieConsent('fast_qlist') ) {
                    get_fast_qlist();
                }

                if (in_array($video['status'], ['Processing', 'Waiting'])) {
                    $ids_to_check_progress[] = $video['videoid'];
                }
                if (config('channel_video_style') == 'modern') {
                    $template = "video-modern.html";
                } else {
                    $template = 'video-classic.html';
                }

                $video_blocks[] = [
                    'html' => trim(getTemplate('blocks/videos/'.$template))
                    ,'id'  => $video['videoid']
                ];
            }
            echo json_encode(['videos'=>$video_blocks, 'ids_to_check_progress'=>$ids_to_check_progress]);
            break;

        case 'channelMorePhotos':
            $load_hit = $_POST['loadHit'];
            $load_limit = $_POST['loadLimit'];
            $user = $_POST['user'];
            $start = $load_limit * $load_hit - $load_limit;
            $sql_limit = "$start, $load_limit";
            $total_items = $_POST['totalPhotos'];
            $items = Photo::getInstance()->getAll(['userid' => $user, 'order' => 'date_added DESC', 'limit' => $sql_limit]);
            if ($start >= $total_items) {
                return false;
            }
            foreach ($items as $key => $p_list) {
                assign('photo', $p_list);
                assign('display_type', 'view_channelAjax');
                echo trim(Fetch('/blocks/photo.html'));
            }
            break;

        default:
            break;
    }
}
