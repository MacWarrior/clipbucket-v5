<?php
	/*
	 ***********************************************************************
	 | Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.
	 | @ Author 	: ArslanHassan
	 | @ Software 	: ClipBucket , © PHPBucket.com
	 *************************************************************************
	*/

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Tool Box', 'url' => '');
	$breadcrumb[1] = array('title' => 'Action Logs', 'url' => '/admin_area/action_logs.php?type=login');

	//Getting User List
	if (isset($_GET['clean'])) {
		global $db;
		$db->Execute('TRUNCATE TABLE '.tbl('action_log'));
	}

	if (isset($_GET['type'])) {
		$type = $_GET['type'];
		$result_array['type'] = $type;
	}
	if (isset($_GET['limit'])) {
		$result_array['limit'] = $_GET['limit'];
	} else {
		$result_array['limit'] = 20;
	}
	if(!$array['order'])
		$result_array['order'] = " DESC ";

	$logs = fetch_action_logs($result_array);
	assign('total_logs',count($logs));
	assign('logs', $logs);
	subtitle("Action Logs");
	template_files('action_logs.html');
	display_it();
