<?php
	/*
	 ***************************************************************
	 | Copyright (c) 2007-2008 Clip-Bucket.com. All rights reserved.
	 | @ Author : ArslanHassan
	 | @ Software : ClipBucket , © PHPBucket.com
	 ****************************************************************
	*/

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Tool Box', 'url' => '');
	$breadcrumb[1] = array('title' => 'Server Configuration Info', 'url' => '/admin_area/cb_server_conf_info.php');

	$post_max_size = ini_get('post_max_size');
	$memory_limit = ini_get('memory_limit');
	$upload_max_filesize = ini_get('upload_max_filesize');
	$max_execution_time = ini_get('max_execution_time');

	assign("post_max_size",$post_max_size);
	assign("memory_limit",$memory_limit);
	assign("upload_max_filesize",$upload_max_filesize);
	assign("max_execution_time",$max_execution_time);
	assign('VERSION',VERSION);

	subtitle("ClipBucket Server Module Checker");
	template_files("cb_server_conf_info.html");
	display_it();
