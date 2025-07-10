<?php

const THIS_PAGE = 'display_option_update';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!is_numeric($_POST['admin_pages']) || $_POST['admin_pages'] < 1) {
    e(lang('max_option_display'));
    $success = false;
} else {
    $num = $_POST['admin_pages'];
    $success = true;
    e(lang('successful'),'m');
    myquery::getInstance()->Set_Website_Details('admin_pages', $num);
}

echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg(),
]);
