<?php
define('THIS_PAGE', 'cb_install');

require_once dirname(__DIR__ ). DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('includes') . 'clipbucket.php';

$modes = [
    'agreement',
    'precheck',
    'permission',
    'database',
    'dataimport',
    'adminsettings',
    'sitesettings',
    'finish'
];

$mode = $_POST['mode'] ?? false;

if (!$mode || !in_array($mode, $modes)) {
    $mode = 'agreement';
}

/**
 * Clipbucket modes
 * modes which requires clipbucket core files so installer
 * function file does not create a conflict
 */
$cbarray = ['adminsettings', 'sitesettings', 'finish'];

if (in_array($mode, $cbarray)) {
    require_once DirPath::get('includes') . 'config.inc.php';
}

require_once DirPath::get('cb_install') . 'functions_install.php';
require_once DirPath::get('cb_install') . 'modes/body.php';
