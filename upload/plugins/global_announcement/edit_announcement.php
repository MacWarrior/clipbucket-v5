<?php
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Plugin Manager', 'url' => '');
	$breadcrumb[1] = array('title' => 'Edit Announcement', 'url' => PLUG_URL.'/global_announcement/edit_announcement.php');

	require_once '../../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('admin_access');
	$pages->page_redir();

	if(isset($_POST['update'])) {
		$text = mysql_clean($_POST['text']);
		update_announcement($text);
		$msg = e("Announcement has been updated",'m');
	}

	global $db;
	$ann_array = $db->_select('SELECT * FROM '.tbl("global_announcement"));

	if(is_array($ann_array)){
		assign('announcement', $ann_array[0]['announcement']);
    } else {
		assign('announcement', '');
    }

	subtitle("Announcement Manager");
	template_files('edit_announcement.html');
	display_it();
