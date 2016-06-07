<?php
require_once '../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();
/* Assigning page and subpage */
if(!defined('MAIN_PAGE')){
	define('MAIN_PAGE', 'Stats And Configurations');
}
if(!defined('SUB_PAGE')){
	define('SUB_PAGE', 'Update Logo');
}
$target_dir = STYLES_DIR."/cb_28/theme/images/";
$source = BASEURL.'/styles/cb_28/theme/images/logo.png';

// Upload and Rename File

if (isset($_POST['submit']))
{

	$filename = $_FILES["fileToUpload"]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["fileToUpload"]["size"];
	$allowed_file_types = array('.png');	

	if (in_array($file_ext,$allowed_file_types) && ($filesize < 4000000))
	{	
		// Rename file
		$newfilename = 'logo' . $file_ext;
		unlink($target_dir."logo.png");
		if (file_exists($target_dir . $newfilename))
		{
			// file already exists error
				e(lang("You have already uploaded this file."),"e");
		}
		else
		{		

			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newfilename);	
			e(lang("File uploaded successfully."),"m");
		}
	}
	elseif (empty($file_basename))
	{	
		// file selection error
		e(lang("Please select a file to upload."),"m");
	} 
	elseif ($filesize > 4000000)
	{	
		// file size error
		e(lang("The file you are trying to upload is too large."),"e");
	}
	else
	{

		e(lang("Only these file typs are allowed for upload: ".implode(', ',$allowed_file_types)),"e");
		unlink($_FILES["fileToUpload"]["tmp_name"]);
	}
}

assign('source',$source);
subtitle("Update Logo");
template_files('upload_logo.html');
display_it();
?>