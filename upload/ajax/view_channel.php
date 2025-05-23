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

            $video_blocks = [];
            foreach ($items as $key => $video) {
                assign('video', $video);
                assign('width', 270);
                get_fast_qlist();
                $video_blocks[] = trim(getTemplate('blocks/videos/video-'.config('channel_video_style').'.html'));
            }
            echo json_encode($video_blocks);
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
            # code...
            break;
    }
}
