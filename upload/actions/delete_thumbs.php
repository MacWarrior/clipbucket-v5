<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

# Generating more thumbs
$data = get_video_details($_POST['videoid']);

$num = $_POST['num'];
delete_video_thumb($data, $num);
echo json_encode(['msg'=>getTemplateMsg()]);