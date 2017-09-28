<?php
	// TODO : Complete URL
	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Clip-Bucket Helper', 'url' => '');
	$breadcrumb[1] = array('title' => 'Cron Jobs', 'url' => '');

	template_files(PLUG_DIR.'/clipbucket_helper/admin/cron_jobs.html',true);
