<?php
define('THIS_PAGE', 'check_timezone');

require_once dirname(__DIR__ ). DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once DirPath::get('vendor') . 'autoload.php';
require_once DirPath::get('includes') . 'common.php';
require_once DirPath::get('includes') . 'config.inc.php';
require_once DirPath::get('classes') . 'DiscordLog.php';
require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('classes') . 'system.class.php';

$success= true;
if (empty($_POST['timezone'])) {
    $success = false;
    e(lang('missing_timezone'));
} else {
    date_default_timezone_set($_POST['timezone']);
    $res = [];
    $success = System::isDateTimeSynchro($res);
    if (!$success) {
        e(lang('timezone_not_corresponding',$_POST['timezone']));
    }
}
echo json_encode(['success'=>$success, 'msg'=>getTemplateMsg()]);
