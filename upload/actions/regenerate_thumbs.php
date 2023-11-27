<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

# Generating more thumbs
$data = get_video_details($_POST['videoid']);
generatingMoreThumbs($data, true);

switch($_POST['origin']){
    default:
    case 'edit_video':
        $thumb_mini_list = return_thumb_mini_list($data);
        $returnJson = json_decode($thumb_mini_list, true);

        ob_start();
        show_player(['vdetails' => $data]);
        $returnJson['player'] = ob_get_clean();

        echo json_encode($returnJson);
        die();

    case 'upload_thumb':
        display_thumb_list($data);
        die();
}
