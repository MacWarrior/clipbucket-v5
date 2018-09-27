<?php
	require_once('../../../includes/admin_config.php');

	$days = 10;
	$last_week = time()-86400*$days + 86400;
	$the_last_week = date('M d', $last_week);
	$vid_stats = $data['video_stats'];
	$vid_stats = json_decode($vid_stats);

	//Getting This Weeks Data
	$year = array();
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
	$videos['uploads'] = $cbvid->get_videos(array("count_only"=>true,"date_span"=>"this_month"),TRUE);
	$videos['processing'] = $cbvid->get_videos(array("count_only"=>true,"status"=>"Processing","date_span"=>"this_month"),TRUE);
	$videos['active'] = $cbvid->get_videos(array("count_only"=>true,"active"=>"yes","date_span"=>"this_month"),TRUE);
	$V = array(array(lang('uploaded'),$videos['uploads']),array(lang('processing'),$videos['processing']),array(lang('active'),$videos['active']));
	$array_video = array('label' => lang('videos'),'data'=>$V);

	//Users
	$users['signups'] = $userquery->get_users(array("count_only"=>true,"date_span"=>"this_month"));
	$users['inactive'] = $userquery->get_users(array("count_only"=>true,"date_span"=>"this_month","status"=>'ToActivate'));
	$users['active'] = $userquery->get_users(array("count_only"=>true,"date_span"=>"this_month","status"=>'Ok'));
	$U = array(array(lang('signups'),$users['signups']),array(lang('inactive'),$users['inactive']),array(lang('active_users'),$users['active']));
	$array_user = array('label' => lang('users'),'data'=>$U);

	echo json_encode(array($array_user,$array_video));
