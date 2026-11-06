<?php
const THIS_PAGE = 'page_update_order';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

$permission = 'basic_settings';
if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '275')) {
    $permission = 'web_config_access';
}
User::getInstance()->hasPermissionAjax($permission);

$success = false;
if (!isset($_POST['page_ids']) || !is_array($_POST['page_ids'])) {
    e(lang('missing_params'));
} else {
    $success = cbpage::getInstance()->update_order($_POST['page_ids']);
    if ($success) {
        e(lang('page_order_has_been_updated'), 'm');
    }
}

echo json_encode([
    'success' => $success,
    'msg'     => getTemplateMsg()
]);
