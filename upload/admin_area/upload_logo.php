<?php
	/*
	* File is used for uploading logo in ClipBucket
	*/

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'General Configurations', 'url' => '');
	$breadcrumb[1] = array('title' => 'Update Logo', 'url' => '/admin_area/upload_logo.php');

	$source = BASEURL.'/styles/cb_28/theme/images/logo.png';

	// Upload and Rename File
	if (isset($_POST['submit'])) {
		// function used to upload site logo.
		upload_logo() ;
	}

	assign('source',$source);
	subtitle("Update Logo");
	template_files('upload_logo.html');
	display_it();
