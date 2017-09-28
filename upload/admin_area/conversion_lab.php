<?php
	/**
	 * View User Details
	 * @author:Arslan
	 * @Since : Oct 16 09
	 */
	require_once '../includes/admin_config.php';

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Tool Box', 'url' => '');
	$breadcrumb[1] = array('title' => 'Conversion Lab &alpha;', 'url' => '/admin_area/conversion_lab.php');

	//Getting list of available testing videos
	$testVidsDir = ADMINBASEDIR.'/lab_resources/testing_videos';
	$vidFiles = glob($testVidsDir.'/*');
	$vdoFiles = array();
	foreach($vidFiles as $vidFile)
	{
		$vdoFiles[] = array('path'=>$vidFile,'name'=>getName($vidFile).'.'.getExt($vidFile));
	}

	assign('vdoFiles',$vdoFiles);
	subtitle("Conversion lab for ClipBucket conversion testing");
	template_files("conversion_lab.html");
	display_it();
