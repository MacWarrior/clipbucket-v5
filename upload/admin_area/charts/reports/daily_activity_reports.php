<?php
error_reporting(E_ALL);
require_once('../../../includes/admin_config.php');

$days = 10;
$last_week = time()-86400*$days + 86400;
$the_last_week = date('M d', $last_week);

$vid_stats = $data['video_stats'];
$vid_stats = json_decode($vid_stats);

$year = array();

//Getting This Weeks Data
for($i=0;$i<$days;$i++)
{
	if($i<$days)
	{
		$date_pattern = date("Y-m-d",$last_week+($i*86400));
		$data = $db->select(tbl("stats"),"*"," date_added LIKE '%$date_pattern%' ",1);
		$data = $data[0];
		$datas[] = $data;
	}
	
	$year[] = date("M d",$last_week+($i*86400));
}
 //Videos
echo $_post['videos'];

$date_pattern = date("Y-m-d");

$videos['uploads'] = $cbvid->get_videos(array("count_only"=>true,"date_span"=>"today"),TRUE);
$videos['processing'] = $cbvid->get_videos(array("count_only"=>true,"status"=>"Processing","date_span"=>"today"),TRUE);
$videos['active'] = $cbvid->get_videos(array("count_only"=>true,"active"=>"yes","date_span"=>"today"),TRUE);
$V = array(array('uploads',$videos['uploads']),array('processing',$videos['processing']),array('active',$videos['active'])); 

//Users
$users['signups'] = $userquery->get_users(array("count_only"=>true,"date_span"=>"today"));
$users['inactive'] = $userquery->get_users(array("count_only"=>true,"date_span"=>"today","status"=>'ToActivate'));
$users['active'] = $userquery->get_users(array("count_only"=>true,"date_span"=>"today","status"=>'Ok'));
//Views
$user_views = $db->select(tbl("users"),"SUM(profile_hits) as total_views"," doj LIKE '%$date%'");
//Total Comments
$user_comments = $db->select(tbl("users"),"SUM(comments_count) as total_comments"," doj LIKE '%$date%'");

$U = array(array('signups',$users['signups']),array('inactive',$users['inactive']),array('Active User',$users['active']),array('views User',$users['views']),array('comments User',$users['comments'])); 

//Make arrays for json
$array_video = array('label' => 'Videos','data'=>$V);
$array_user = array('label' => 'Users','data'=>$U);

echo json_encode(array($array_user,$array_video));
