<?php

require_once("../includes/config.inc.php");

if (isset($_POST["vid"])) {
    $vid = $_POST["vid"];
    $video = $cbvid->get_video($vid);
    echo json_encode($video);
} else {
    echo json_encode(["video" => false]);
}