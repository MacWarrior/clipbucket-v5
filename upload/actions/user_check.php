<?php
const THIS_PAGE = 'user_check';
const IS_AJAX = true;

require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('private_msg_access');

$msg ='';
$success = false;
if (empty($_POST['username'])) {
    $msg = lang('missing_params');
    e($msg);
} else {
    $res = User::getInstance()->getOne(['username_strict' => $_POST['username'], 'not_userid'=>userquery::getInstance()->get_anonymous_user()]);
    if (empty($res)) {
        $msg = lang('user_no_exist_wid_username', $_POST['username']);
        e($msg);
    } elseif($res['userid'] == User::getInstance()->getCurrentUserID()) {
        $msg = lang('you_cant_send_pm_yourself');
        e($msg, 'w');
    } else {
        $success = true;
    }
}
echo json_encode(['msg' => getTemplateMsg(), 'success' => $success, 'text_msg' => $msg]);
