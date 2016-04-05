<?php

	require '../includes/config.inc.php';
	if (isset($_POST['mode'])) {
		sleep(5);
		$mode = $_POST['mode'];
		switch ($mode) {
			case 'channelMore':
				global $db, $cbvid, $Smarty;
				$load_hit = $_POST['loadHit'];
				$load_limit = $_POST['loadLimit'];
				$user = $_POST['user'];
				$start = $load_limit * $load_hit - $load_limit;
				$sql_limit = "$start, $load_limit";
				$total_items = $_POST['totalVids'];
				$items = get_videos(array("user"=>$user, "order"=>"date_added DESC","limit"=>$sql_limit));
				if ($start >= $total_items) {
					echo "none";
					return false;
				}
				foreach ($items as $key => $video) {
					assign("video", $video);
					assign("display_type","ajaxHome");
					echo trim(Fetch('/blocks//videos/video.html'));
				}
				break;
			
			default:
				# code...
				break;
		}
	}

?>