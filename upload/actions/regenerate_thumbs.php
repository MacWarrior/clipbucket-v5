<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

# Generating more thumbs
$data = get_video_details($_POST['videoid']);
generatingMoreThumbs($data);
if ($_POST['origin'] == 'edit_video') {
    $thumb_mini_list = return_thumb_mini_list($data);
    ob_start();
    display_flash_player($data);
    $player = ob_get_clean();
    $returnJson = json_decode($thumb_mini_list, true);
    $returnJson['player'] = $player;
    echo json_encode($returnJson);
} elseif ($_POST['origin'] == 'upload_thumb') {
    display_thumb_list($data);
}
