<?php
	/*
 ****************************************************************************************************
 | Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.											|
 | @ Author 	: ArslanHassan																		|
 | @ Software 	: ClipBucket , © PHPBucket.com														|
 ****************************************************************************************************
*/

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('video_moderation');
	$pages->page_redir();

	$video = $_GET['video'];
	$data = get_video_details($video);

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Videos', 'url' => '');
	$breadcrumb[1] = array('title' => 'Videos Manager', 'url' => '/admin_area/video_manager.php');
	$breadcrumb[2] = array('title' => 'Editing : '.display_clean($data['title']), 'url' => '/admin_area/edit_video.php?video='.display_clean($video));

	if(@$_GET['msg']){
		$msg[] = clean($_GET['msg']);
	}

	//Updating Video Details
	if(isset($_POST['update']))
	{
		$Upload->validate_video_upload_form();
		if(empty($eh->error_list))
		{
			$myquery->update_video();
			$myquery->set_default_thumb($video,$_POST['default_thumb']);

			$data = get_video_details($video);
		}
	}

	//Performing Video Actions
	if($_GET['mode']!=''){
		$modedata = $cbvid->action($_GET['mode'],$video);
		assign("modedata",$modedata);
	}
	
	//Check Video Exists or Not
	if($myquery->VideoExists($video))
	{
		//Deleting Comment
		$cid = mysql_clean($_GET['delete_comment']);
		if(!empty($cid))
		{
			$myquery->delete_comment($cid);
		}

		Assign('udata',$userquery->get_user_details($data['userid']));
		Assign('data',$data);
	} else {
		$msg[] = lang('class_vdo_del_err');
	}

    $type = "v";
    $comment_cond = array();
    $comment_cond['order'] = " comment_id DESC";
    $comment_cond['videoid'] = $video;
    $comments = getComments($comment_cond);
    assign("comments",$comments);

	//Deleting comment 
	if(isset($_POST['del_cmt'])){
		$cid = mysql_clean($_POST['cmt_id']);
		$myquery->delete_comment($cid);
	}

	if(!$array['order'])
		$result_array['order'] = " doj DESC LIMIT 1 ";

	$users = get_users($result_array);

	Assign('users', $users);

	if(!$array['order'])
		$result_array['order'] = " views DESC LIMIT 8 ";
	$videos = get_videos($result_array);

	Assign('videos', $videos);

	$numbers = array(100,1000,15141,3421);
	function format_number($number)
	{
		if($number >= 1000) {
			return $number/1000 . "k"; // NB: you will want to round this
		}
		return $number;
	}

	if(function_exists("get_ep_videos"))
	{
		$ep_videos = get_ep_videos();
		if(isset($_POST['update_order']))
		{
			if(is_array($ep_videos))
			{
				foreach($ep_videos as $epvid)
				{
					$order = $_POST['ep_order_'.$epvid['pick_id']];
					move_epick($epvid['videoid'],$order);
				}
			}
			$ep_videos = get_ep_videos();
		}
	}


	$get_limit = create_query_limit($page,5);
	$videos = $cbvid->action->get_flagged_objects($get_limit);
	Assign('flagedVideos', $videos);

	$comments = getComments($comment_cond);
	assign("comments",$comments);

	subtitle("Edit Video");
	template_files('edit_video.html');
	display_it();
