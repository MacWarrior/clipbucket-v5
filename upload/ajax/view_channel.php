<?php
$is_ajax = true;
require '../includes/config.inc.php';
if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
    switch ($mode) {
        case 'channelMore':
            global $db, $cbvid, $Smarty;
            $load_hit = $_POST['loadHit'];
            $load_limit = $_POST['loadLimit'];
            $user = $_POST['userid'];
            $start = $load_limit * $load_hit - $load_limit;
            $sql_limit = "$start, $load_limit";
            $total_items = $_POST['totalVids'];
            $items = get_videos(array("user"=>$user, "order"=>"date_added DESC","limit"=>$sql_limit));
            if ($start >= $total_items) {
                return false;
            }
            foreach ($items as $key => $video) {
                assign("video", $video);
                assign("display_type","ajaxHome");
                echo trim(Fetch('/blocks//videos/video.html'));
            }
            break;

        case 'channelMorePhotos':
            global $db, $cbvid, $Smarty;
            $load_hit = $_POST['loadHit'];
            $load_limit = $_POST['loadLimit'];
            $user = $_POST['user'];
            $start = $load_limit * $load_hit - $load_limit;
            $sql_limit = "$start, $load_limit";
            $total_items = $_POST['totalPhotos'];
            $items = get_photos(array("user"=>$user, "order"=>"date_added DESC","limit"=>$sql_limit));
            if ($start >= $total_items) {
                return false;
            }
            foreach ($items as $key => $p_list) {
                assign("photo", $p_list);
                assign("display_type","view_channelAjax");
                echo trim(Fetch('/blocks/photo.html'));
            }
            break;

        default:
            # code...
            break;
    }
}
