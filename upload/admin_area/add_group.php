<?php
	/* TODO : Is this page still used ? */
	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('member_moderation');
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Groups', 'url' => '');
	$breadcrumb[1] = array('title' => 'Add Group', 'url' => '/admin_area/add_group.php');

	// Creating Group if button is pressed
	if(isset($_POST['create_group'])) {
		$cbgroup->create_group($_POST,userid(),true);
	}

	subtitle(lang('grp_crt_grp'));
	template_files('add_group.html');
	display_it();
