<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

# Generating more thumbs
$data = get_video_details($_POST['videoid']);

$num = $_POST['num'];
delete_video_thumb($data, $num);
display_thumb_list($data);
