<?php
	// TODO : Complete URL
	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'CB Subtitles', 'url' => '');
	$breadcrumb[1] = array('title' => 'Update Settings', 'url' => '');

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('admin_access');
	$pages->page_redir();

	$links = getBeastLinks(true);
	subtitle("Social Beast > Social Links");
	template_files(SOCIAL_BEAST_ADMIN_DIR.'/links.html');
