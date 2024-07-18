<?php
define('THIS_PAGE', 'regenerate_thumbs');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

# Generating more thumbs
$data = get_video_details($_POST['videoid']);

sendClientResponseAndContinue(function () use($data) {
    display_thumb_list_custom_only($data);
});
generatingMoreThumbs($data, true);
die();
