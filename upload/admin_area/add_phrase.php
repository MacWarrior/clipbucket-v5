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
	$userquery->login_check('web_config_access');
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'General Configurations', 'url' => '');
	$breadcrumb[1] = array('title' => 'Add New Phrases', 'url' => '/admin_area/add_phrases.php');

	if(isset($_POST['add_phrase']))
	{
		$name = mysql_clean($_POST['name']);
		$text = mysql_clean($_POST['text']);
		$lang_code = mysql_clean($_POST['lang_code']);
		$lang_obj->add_phrase($name,$text,$lang_code);
	}

	subtitle("Add Language Phrase");
	template_files('add_phrase.html');
	display_it();
