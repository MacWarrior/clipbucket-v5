<?php
define("THIS_PAGE",'download_photo');
define("PARENT_PAGE",'photos');

require 'includes/config.inc.php';
$pages->page_redir();

$key = $cbphoto->decode_key($_GET['download']);

if(empty($key)){
	header("location:".BASEURL);
} else {
	$cbphoto->download_photo($key);
}

display_it();
