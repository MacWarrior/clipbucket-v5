<?php
define('THIS_PAGE', 'validate_licence');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';
require_once DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

Migration::updateConfig('license_validation', date('Y-m-d H:i:s'));
echo json_encode(['success' =>true]);