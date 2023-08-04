<?php
define('THIS_PAGE', 'cb_install');
include_once('../includes/clipbucket.php');

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
$baseDir = dirname(__FILE__, 2);

if (in_array($mode, $cbarray)) {
    require_once '../includes/config.inc.php';
}

require_once 'functions.php';
require_once 'modes/body.php';
