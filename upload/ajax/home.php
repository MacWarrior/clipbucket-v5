<?php

	/**
	* File: Home Ajax
	* Description: ClipBucket home page will now be Ajax based to imporve page loading
	* and to enhance user experience. This file will handle all ajax requests
	* for ClipBucket's home page
	* @since: 14th March, 2016, ClipBucket 2.8.1 
	* @author: Saqib Razzaq
	* @modified: 14th March, 2016
	*/

	require '../includes/config.inc.php';

	if (isset($_POST['load_type'])) {
		$load_type = $_POST['load_type'];

		if (isset($_POST['load_mode'])) {
			$load_mode = $_POST['load_mode'];
			if ($load_mode == 'featured') {
				$params['featured'] = "yes";
			}
		}
		if (isset($_POST['load_limit'])) {
			$load_limit = $_POST['load_limit'];
		} else {
			$load_limit = "8";
		}
		if (isset($_POST['load_hit'])) {
			$cur_load_hit = $_POST['load_hit'];
			$start = $load_limit * $cur_load_hit - $load_limit;
			if ($start < 1)  {
				$start = "1";
			}
		} else {
			$start = "1";
		}

		$params = array();
		$params['limit'] = "$start,$load_limit";
		switch ($load_type) {
			case 'video':
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

		if (is_array($data)) {
			$json_string['loadhit'] = $cur_load_hit + 1;
			$json_string['array_meta'] = $data;
			echo json_encode($json_string);
		}
	} else {
		$msg = array();
		$msg['error'] = "Invalid request made";
		echo json_encode($msg);
	}

	
	
	

?>