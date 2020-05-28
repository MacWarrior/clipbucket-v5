<?php
	/**
	* File: Channels
	* Description: Used to display list of channels (users)
	* @author: Arslan Hassan, Saqib Razzaq
	* @since: 2007
	* @website: clip-bucket.com
	* @modified: Feb 26, 2016 ClipBucket 2.8.1 [ Saqib Razzaq ]
	*/

	define("THIS_PAGE",'channels');
	define("PARENT_PAGE",'channels');
	require 'includes/config.inc.php';
	$pages->page_redir();
	$userquery->perm_check('view_channels',true);
	global $pages;
	$assign_arry = array();
	$sort = $_GET['sort'];
	$u_cond = array('category'=>mysql_clean($_GET['cat']),'date_span'=>mysql_clean($_GET['time']));
	switch($sort)
	{
		case "most_recent":
		default:
			$u_cond['order'] = " doj DESC ";
			break;
		case "most_viewed":
			$u_cond['order'] = " profile_hits DESC ";
			break;
		case "featured":
			$u_cond['featured'] = "yes";
			break;
		case "top_rated":
			$u_cond['order'] = " rating DESC";
			break;
		case "most_commented":
			$u_cond['order'] = " total_comments DESC";
			break;
	}
	$page = mysql_clean($_GET['page']);
	$get_limit = create_query_limit($page,CLISTPP);
	$count_query = $ulist = $u_cond;
	$ulist['limit'] = $get_limit;
	$users = get_users($ulist);
	$counter = get_counter('channel',$count_query);

	if(!$counter) {
		//Collecting Data for Pagination
		$ucount = $u_cond;
		$ucount['count_only'] = true;
		$total_rows = get_users($ucount);
		$counter = $total_rows;
		update_counter('channel',$count_query,$counter);
	}

	$total_pages = count_pages($counter,CLISTPP);
	//Pagination
	$extra_params=NULL;
	$tag='<li><a #params#>#page#</a><li>';
	$pages->paginate($total_pages,$page,$link,$extra_params,$tag);
	
	$sorting_links=sorting_links();
	$time_links=time_links();
	
	foreach($sorting_links as $na_me => $name){
			if ($na_me == $_GET['sort']) 
				$sort_name = $sorting_links[$na_me];
	}
	
	foreach($time_links as $na_me => $name){
			if ($na_me == $_GET['time']) 
				$sort_time = $time_links[$na_me];
	}
	
	if (!$_GET['seo_cat_name']) $catname='All';
	else $catname = str_replace("-", " ", $_GET['seo_cat_name']);
	
	$subtitle = $catname .' &raquo; '. $sort_name .' &raquo; '. $sort_time .' &raquo; Channels';
	
	subtitle(lang($subtitle));
	assign('catname', $catname);
	assign('users', $users);	
	template_files('channels.html');
	display_it();
