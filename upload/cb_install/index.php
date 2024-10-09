<?php
define('THIS_PAGE', 'cb_install');

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once DirPath::get('vendor') . 'autoload.php';
require_once DirPath::get('classes') . 'DiscordLog.php';
require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('includes') . 'clipbucket.php';
require_once DirPath::get('classes') . 'system.class.php';
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

$whoops = new \Whoops\Run;
if (file_exists(DirPath::get('temp') . 'development.dev')) {
    define('DEVELOPMENT_MODE', true);

    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    define('DEVELOPMENT_MODE', false);
}
$whoops->pushHandler(function($e){
    $message = $e->getMessage().PHP_EOL.$e->getTraceAsString();
    error_log($message);
    DiscordLog::sendDump($message);
});
$whoops->register();

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

$has_translation = class_exists('Language');

require_once DirPath::get('cb_install') . 'functions_install.php';
if (!empty($_POST['language'])) {
    Language::getInstance()->make_default($_POST['language']);
    Language::getInstance()->init();
    $has_translation = true;
}
require_once DirPath::get('cb_install') . 'modes/body.php';
