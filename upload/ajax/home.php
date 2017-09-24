<?php

	/**
	* File: Home Ajax
	* Description: ClipBucket home page will now be Ajax based to imporve page loading
	* and to enhance user experience. This file will handle all ajax requests
	* for ClipBucket's home page
	* @since: 14th March, 2016, ClipBucket 2.8.1 
	* @author: Saqib Razzaq
	* @modified: 8th April, 2016
	*/

	require '../includes/config.inc.php';
	$params = array();
	if (isset($_POST['load_type']))
	{
		$load_type = $_POST['load_type'];
		if (isset($_POST['load_mode']))
		{
			$load_mode = $_POST['load_mode'];
			if ($load_mode == 'featured') {
				$params['featured'] = "yes";
			}
			if ($load_mode == 'recent') {
				$params['order'] = 'date_added DESC';
			} else {
				$params['order'] = 'views';
			}
		}

		if( isset($_POST['current_displayed']) )
		{
			$start = $_POST['current_displayed'];
		} else {
			$start = '0';
		}

		if( isset($_POST['wanted']) )
		{
			$end = $_POST['wanted'];
		} else {
			$end = '6';
		}

		$params['limit'] = "$start,$end";

		if( isset($_POST['first_launch']) && $_POST['first_launch'] = 'true' )
		{
			$params['count_only'] = true;
			$params['status'] = 'Successful';
			$total_vids = get_videos($params);
			assign("total_vids", $total_vids);
		} else {
			assign("total_vids",'');
		}

		switch ($load_type)
		{
			case 'video':
				$params['count_only'] = false;
				$params['status'] = 'Successful';
				$data = get_videos($params);
				break;
			case 'users':
				$data = get_users($params);
				break;
			case 'photos':
				$data = get_photos($params);
				break;
			case 'collections':
				$data = get_collections($params);
				break;
			
			default:
				$data = get_videos($params);
				break;
		}

		if (is_array($data))
		{
			if (count($data) >= 1)
			{
				$json_string['array_meta'] = $data;
				if ($load_mode == 'recent') {
					$display_type = 'ajaxHome';
				} else {
					$display_type = 'featuredHome';
				}
				$quicklists = $_COOKIE['fast_qlist'];
				$clean_cookies = str_replace(array("[","]"), "", $quicklists);
				$clean_cookies = explode(",", $clean_cookies);
				$clean_cookies = array_filter($clean_cookies);
				assign("qlist_vids", $clean_cookies);
				foreach ($data as $key => $video)
				{
					assign("video",$video);
					assign("display_type",$display_type);
					Template('blocks/videos/video.html');
				}
			} else {
				$msg = array();
				$msg['notice'] = "You've reached end of list";
				echo json_encode($msg);
			}
		}
	} else {
		$msg = array();
		$msg['error'] = "Invalid request made";
		echo json_encode($msg);
	}
