<?php

define('THIS_PAGE', 'check_timezone');
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');
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
