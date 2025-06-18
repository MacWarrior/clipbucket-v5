<?php
define('THIS_PAGE', 'cb_install');
session_start();
require_once dirname(__DIR__ ). DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once DirPath::get('vendor') . 'autoload.php';
require_once DirPath::get('classes') . 'DiscordLog.php';
require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('classes') . 'system.class.php';
require_once DirPath::get('classes') . 'errorhandler.class.php';
require_once DirPath::get('includes') . 'functions_template.php';
require_once DirPath::get('cb_install') . 'functions_install.php';

if (!file_exists(DirPath::get('temp') . 'install.me') && !file_exists(DirPath::get('temp') . 'install.me.not')) {
    return false;
}

$result = Update::updateGitSources();
$_SESSION['needed_update'] = true;
$return = ['success'=>$result];
if( empty($result) || $result === true ){
    $return['msg']='ClipbucketV5 has been successfully updated !';
} else {
    $return['err']='An error occurred during update : ' . $result . '<br/>Please try again';
}
echo json_encode($return);
