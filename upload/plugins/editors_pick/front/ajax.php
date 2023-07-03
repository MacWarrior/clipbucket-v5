<?php
define('THIS_PAGE', 'ajax');

require_once dirname(__DIR__, 3) . '/includes/config.inc.php';

if (isset($_POST['vid'])) {
    $vid = mysql_clean($_POST['vid']);
    $vdetails = get_video_details($vid);
    if ($vdetails) {
        assign('video', $vdetails);
        $data = Fetch('blocks/videos/video_block.html');
        echo json_encode(['data' => $data]);
    } else {
        echo json_encode(['data' => '<em>No Video</em>']);
    }
} else {
    header('location:' . BASEURL);
    die();
}
