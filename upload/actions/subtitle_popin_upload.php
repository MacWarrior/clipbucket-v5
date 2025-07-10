<?php
define('THIS_PAGE', 'popin_upload_subtitle');

require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('edit_video');
require_once DirPath::get('core') .  'popin_upload_subtitle_core.php';