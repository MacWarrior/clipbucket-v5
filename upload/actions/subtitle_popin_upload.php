<?php
const THIS_PAGE = 'popin_upload_subtitle';

require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if (config('can_upload_subtitles') != 'yes') {
    $response['success'] = false;
    echo json_encode($response);
    die;
}
User::getInstance()->hasPermissionAjax('edit_video');
require_once DirPath::get('core') .  'popin_upload_subtitle_core.php';