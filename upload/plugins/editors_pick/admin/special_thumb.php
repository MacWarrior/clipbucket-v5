<?php
	/*
	 ***************************************************************
	 | Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.
	 | @ Author : ArslanHassan
	 | @ Software : ClipBucket , © PHPBucket.com
	 ****************************************************************
	*/

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$pages->page_redir();

	// TODO : Complete URL
	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Videos', 'url' => '');
	$breadcrumb[1] = array('title' => 'Editor\'s Pick', 'url' => '');

	$vid = $_GET['vid'];

	subtitle("Editor's Pick");
	template_files(CB_EP_BASEDIR.'/admin/styles/special_thumb.html');
