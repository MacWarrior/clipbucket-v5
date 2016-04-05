<?php
	require '../includes/config.inc.php';
	if (isset($_POST['mode'])) {
		$mode = $_POST['mode'];
		global $db;
		switch ($mode) {
			case 'emailExists':
				$email = $_POST['email'];
			    $check = $db->select(tbl('users'),"email"," email='$email'");
			    if (!$check) {
			    	echo "NO";
			    }
				break;

			case 'userExists':
				$username = $_POST['username'];
			    $check = $db->select(tbl('users'),"username"," username='$username'");
			    if (!$check) {
			    	echo "NO";
			    }
				break;
			
			default:
				# code...
				break;
		}
	}
?>