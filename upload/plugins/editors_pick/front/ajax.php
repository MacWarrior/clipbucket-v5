<?php
require '../../../includes/config.inc.php';
if(isset($_POST['vid']))
{
    $vid = mysql_clean($_POST['vid']);
    $vdetails = get_video_details($vid);
    if($vdetails) {
        assign('video',$vdetails);
        $data = Fetch("blocks/videos/video_block.html");
        echo json_encode(array('data'=>$data));
    } else {
        echo json_encode(array('data'=> "<em>No Video</em>"));
    }
} else {
    header("location:".BASEURL);
}
