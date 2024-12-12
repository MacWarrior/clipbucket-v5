<?php
define('THIS_PAGE', 'regenerate_thumbs');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

# Generating more thumbs
$data = get_video_details($_POST['videoid']);

sendClientResponseAndContinue(function () use($data) {
    e(lang('thumb_regen_start'), 'warning');
    display_thumb_list_start($data);
});
generatingMoreThumbs($data, true);
die();
