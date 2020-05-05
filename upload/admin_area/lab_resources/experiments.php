<?php
//setting timeout so that server just dont stuck, right for just 25 seconds
if(!ini_get('safe_mode')) {
    set_time_limit( 25 );
}

require'../../includes/admin_config.php';
require_once(BASEDIR.'/includes/classes/conversion/ffmpeg.class.php');
$testVidsDir = ADMINBASEDIR.'/lab_resources/testing_videos';

$userquery->admin_login_check();

if(isset($_POST['experiment']))
{
	$mode = $_POST['mode'];
	$victim = $_POST['victim'];
	$height = $_POST['height'];
	$width = $_POST['width'];
	$v_bitrate = $_POST['vbr'];
	$a_bitrate = $_POST['abr'];
	$preset = $_POST['preset'];

	switch($mode)
	{
		default:
            echo json_encode(array("err"=>"Well hellow :/"));
            break;
	}
}

function theEnd($status=false)
{
	global $msg, $err;
	$errors = array();
	if($err){
	    $errors = implode('',$err);
    }
    $messgs = array();
	if($msg){
	    $messgs = implode('',$msg);
    }
	
	echo json_encode(array('err'=>$errors,'msg'=>$messgs,'status'=>$status));
	exit();
}
