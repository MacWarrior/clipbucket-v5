<?php
	/*
	 *******************************************
	 | Copyright (c) 2007-2009 Clip-Bucket.com & (Arslan Hassan). All rights reserved.
	 | @ Author : ArslanHassan
	 | @ Software : ClipBucket , © PHPBucket.com
	 *******************************************
	*/

	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$userquery->login_check('admin_access');
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Users', 'url' => '');
	$breadcrumb[1] = array('title' => 'Manage categories', 'url' => '/admin_area/user_category.php');

	//Form Processing
	if(isset($_POST['add_cateogry']))
	{
		$userquery->thumb_dir = 'users';
		$userquery->add_category($_POST);
	}

	//Making Category as Default
	if(isset($_GET['make_default']))
	{
		$cid = mysql_clean($_GET['make_default']);
		$userquery->make_default_category($cid);
	}

	//Edit Category
	if(isset($_GET['category']) && !empty($_GET['category']) && is_numeric($_GET['category']) )
	{
		$id_category = $_GET['category'];
		assign("edit_category","show");
		if(isset($_POST['update_category']))
		{
			$userquery->thumb_dir = 'users';
			$userquery->update_category($_POST);
		}

		$cat_details = $userquery->get_category($id_category);
		$breadcrumb[2] = array('title' => 'Editing : '.display_clean($cat_details['category_name']), 'url' => '/admin_area/user_category.php?category='.display_clean($id_category));
		assign('cat_details',$cat_details);
	}

	//Delete Category
	if(isset($_GET['delete_category'])){
		$userquery->delete_category($_GET['delete_category']);
	}

	$cats = $userquery->get_categories();
	//Updating Category Order
	if(isset($_POST['update_order']))
	{
		foreach($cats as $cat)
		{
			if(!empty($cat['category_id']))
			{
				$order = $_POST['category_order_'.$cat['category_id']];
				$userquery->update_cat_order($cat['category_id'],$order);
			}
		}
		$cats = $userquery->get_categories();
	}

	//Assign Category Values
	assign('category',$cats);
	assign('total',$userquery->total_categories());
	Assign('msg',@$msg);
	subtitle("User Category Manager");
	template_files('user_category.html');
	display_it();
