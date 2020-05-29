<?php
include("../includes/config.inc.php");

$mode = $_POST['mode'];

switch($mode)
{
	case "remote_play":
		$duration = $_POST['duration'];
		$thumb_file = $_POST['thumb_file'];
		$url = $_POST['remote_play_url'];
		$ext = strtolower(getExt($thumb_file));
		
		validate_duration($duration);
		check_remote_play_link($url);
		
		if(empty($thumb_file) || ( $ext != 'jpg' && $ext != 'png' && $ext !='gif'))
			e(lang("pelase_select_img_file_for_vdo"));
		if(count($eh->get_error()) > 0){
			$array['err'] = $eh->get_error()[0]['val'];
        }
		
		echo json_encode($array);
	    break;
	
	case "embed":
	default:
		$embed_code = $_POST['embed_code'];
		$duration = $_POST['duration'];
		$thumb_file = $_POST['thumb_file'];
		$ext = strtolower(getExt($thumb_file));
		
		validate_embed_code($embed_code);
		validate_duration($duration);
		
		if(empty($thumb_file) || ( $ext != 'jpg' && $ext != 'png' && $ext !='gif' && $ext !='jpeg')){
			e(lang("pelase_select_img_file_for_vdo"));
        }
		if(count($eh->get_error()) > 0){
			$array['err'] = $eh->get_error()[0]['val'];
        }
		
		echo json_encode($array);
        break;
}
