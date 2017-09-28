<?php
	/*
	 * @since : 2009
	 * @author : Arslan Hassan
	 */

	// TODO : Complete URL
	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Global Announcement', 'url' => '');
	$breadcrumb[1] = array('title' => 'Edit Announcement', 'url' => '');

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('admin_access');
	$pages->page_redir();

	if(isset($_POST['update']))
	{
		$text = mysql_clean($_POST['text']);
		update_announcement($text);
		$msg = e("Announcement has been updated",'m');
	}

	global $db;
	$ann_array = $db->_select('SELECT * FROM '.tbl("global_announcement"));

	if(is_array($ann_array))
		assign('an', $ann_array[0]['announcement']);
	else
		assign('an', '');

	subtitle("Annoucment Manager");
	template_files('edit_announcemnent.html');
	display_it();
