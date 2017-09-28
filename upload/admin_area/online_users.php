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
	$breadcrumb[1] = array('title' => 'View online users', 'url' => '/admin_area/online_users.php');

	if($_GET['kick'])
	{
		if($sess->kick(mysql_clean($_GET['kick'])))
		{
			e("User has been kicked out","m");
		}
	}

	//Getting User List
	$result_array['limit'] = $get_limit;
	if(!$array['order'])
		$result_array['order'] = " doj DESC ";

	$users = get_users($result_array);

	Assign('users', $users);

	$online_users = $userquery->get_online_users(false);
	assign('total',count($online_users));
	assign('online_users',$online_users);
	assign('queryString',queryString(NULL,'kick'));
	subtitle("View online users");
	template_files('online_users.html');
	display_it();
