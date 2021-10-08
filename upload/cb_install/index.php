<?php
define('THIS_PAGE','cb_install');
include('../includes/clipbucket.php');

$modes = array(
    'agreement',
    'precheck',
    'permission',
    'database',
    'dataimport',
    'adminsettings',
    'sitesettings',
    'finish'
);

$mode = $_POST['mode'] ?? false;

if(!$mode || !in_array($mode,$modes)) {
    $mode = 'agreement';
}

$configIncluded = false;
/**
* Clipbucket modes
* modes which requires clipbucket core files so installer
* function file does not create a conflict
*/
$cbarray = array('adminsettings','sitesettings','finish');
$baseDir = dirname(dirname(__FILE__));

if( in_array($mode,$cbarray) ) {
    chdir('..');
    $configIncluded = true;
    require_once 'includes/config.inc.php';
    chdir('cb_install');
}

include('functions.php');
include('modes/body.php');
