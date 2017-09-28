<?php
	/**
	 * @Software : ClipBucket
	 * @Author : Arslan Hassan
	 * @Since : Jan 5 2009
	 * @Function : Add Member
	 * @License : Attribution Assurance License -- http://www.opensource.org/licenses/attribution.php
	 */

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('member_moderation');
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Users', 'url' => '');
	$breadcrumb[1] = array('title' => 'Add Member', 'url' => '/admin_area/add_member.php');

	if(isset($_POST['add_member']))
	{
		if($userquery->signup_user($_POST))
		{
			e(lang("new_mem_added"),"m");
			$_POST = '';
		}
	}

	subtitle("Add New Member");
	template_files('add_members.html');
	display_it();
