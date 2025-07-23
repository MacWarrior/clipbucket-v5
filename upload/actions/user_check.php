<?php
const THIS_PAGE = 'cookie_consent_get';
const IS_AJAX = true;

require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$success = false;
if (empty($_POST['username'])) {
    e(lang('missing_params'));
} else {
    $res = User::getInstance()->getOne(['username_strict' => $_POST['username']]);
    if (empty($res)) {
        e(lang('user_no_exist_wid_username', $_POST['username']));
    } else {
        $success = true;
    }
}
echo json_encode(['msg' => getTemplateMsg(), 'success' => $success]);
