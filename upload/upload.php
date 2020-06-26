<?php
/* 
 *******************************************************************
 | Copyright (c) 2007-2016 Clip-Bucket.com. All rights reserved.	
 | @ Author   : ArslanHassan										
 | @ Software : ClipBucket
 | @ Modified : June 9, 2016 by Saqib Razzaq
 *******************************************************************
*/

	define("THIS_PAGE","upload");
	define("PARENT_PAGE","upload");
	require 'includes/config.inc.php';
	$pages->page_redir();
	subtitle('upload');

	//Checking if user is guest
	$verify_logged_user = userid() ? true : false;

	if(has_access('allow_video_upload',false,$verify_logged_user))
	{
		$step = 1;
		if(isset($_POST['submit_data'])) {
			$Upload->validate_video_upload_form();
			if(empty($eh->get_error())) {
				$step=2;
			}
		}
		
		if(isset($_POST['submit_upload']))
		{
			$file_directory = create_dated_folder(NULL,$_REQUEST['time_stamp']);

			$vid = $Upload->submit_upload();
			$Upload->do_after_video_upload($vid);

			if(!error()){
				e('Video has been Embeded succesfully ..','m');
				$step=3;
			}
		}

		//assigning Form Name [RECOMMEND for submitting purpose]
		assign('upload_form_name','UploadForm');

		//Adding Uploading JS Files
		add_js(array('swfupload/swfupload.js'=>'uploadactive'));
		add_js(array('swfupload/plugins/swfupload.queue.js'=>'uploadactive'));
		add_js(array('swfupload/plugins/handlers.js'=>'uploadactive'));
		add_js(array('swfupload/plugins/fileprogress.js'=>'uploadactive'));
	} else {
		$userquery->logincheck('allow_video_upload',true);
	}

	assign('step',$step);
	assign('extensions', $Cbucket->get_extensions('video'));
	subtitle(lang('upload'));
	//Displaying The Template
	if ( !userid() ) {
		echo '<div id="notlogged_err" class="container alert alert-danger" style="margin-top:70px;">You must login to be able to upload content. Login if you have account or register</div>';
	} else {
		template_files('upload.html');
	}

	display_it();
