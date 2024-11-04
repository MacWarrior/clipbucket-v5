<?php

define('THIS_PAGE', 'check_timezone');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
$success = true;
if (empty($_POST['timezone'])) {
    $success = false;
    e(lang('missing_timezone'));
} else {
    date_default_timezone_set($_POST['timezone']);
    $res = [];
    $success = System::isDateTimeSynchro($res);
    if (!$success) {
        e(lang('timezone_not_corresponding', $_POST['timezone']));
    }
}
echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg()
]);
