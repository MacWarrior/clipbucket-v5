<?php
const THIS_PAGE = 'watch';
require '../includes/config.inc.php';

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];

    switch ($mode) {
        case 'playlistMore':
            global $Smarty;
            $load_hit = $_POST['loadHit'];
            $load_limit = $_POST['loadLimit'];
            $playlist = $_POST['playlist'];
            $start = $load_limit * $load_hit - $load_limit;
            $sql_limit = "$start, $load_limit";
            $total_items = CBvideo::getInstance()->action->count_playlist_items($playlist);
            $items = CBvideo::getInstance()->get_playlist_items($playlist, 'playlist_items.date_added DESC', $sql_limit);
            if ($start >= $total_items) {
                echo 'none';
                return false;
            }
            foreach ($items as $key => $video) {
                assign('video', $video);
                assign('control', 'onWatch');
                assign('pid', $video['playlist_id']);
                echo trim(Fetch('/blocks/manage/account_video.html'));
            }
            break;
    }
}
