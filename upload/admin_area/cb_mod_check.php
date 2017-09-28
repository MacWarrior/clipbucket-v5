<?php
	/*
	 ***************************************************************
	 | Copyright (c) 2007-2008 Clip-Bucket.com. All rights reserved.
	 | @ Author : ArslanHassan
	 | @ Software : ClipBucket , © PHPBucket.com
	 ****************************************************************
	*/
	require_once '../includes/admin_config.php';
	$userquery->admin_login_check();
	$pages->page_redir();

	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Tool Box', 'url' => '');
	$breadcrumb[1] = array('title' => 'Server Modules Info', 'url' => '/admin_area/cb_mod_check.php');

	$ffmpegVersion = check_ffmpeg("ffmpeg");
	assign("ffmpegVersion", $ffmpegVersion);

	$phpVersion = check_php_cli("php");
	assign("phpVersion", $phpVersion);

	$MP4BoxVersion = check_mp4box("MP4Box");
	assign("MP4BoxVersion", $MP4BoxVersion);

	$imagick_version = check_imagick("i_magick");
	assign("imagick_version",$imagick_version);

	$media_info = check_media_info('media_info');
	assign("media_info", $media_info);

	$ffprobe_path = check_ffprobe_path('ffprobe_path');
	assign("ffprobe_path", $ffprobe_path);

	subtitle("ClipBucket Server Module Checker");
	template_files("cb_mod_check.html");
	display_it();
