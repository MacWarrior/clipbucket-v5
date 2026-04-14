<?php
const THIS_PAGE = 'template_save_fields';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
User::getInstance()->hasPermissionAjax('manage_template_access');
$success = true;

if (!in_array($_POST['field'], CBTemplate::$allowed_fields)) {
    e(lang('invalid_field'));
    $success = false;
}
if (empty($_POST['value'])) {
    e(lang('field_cannot_be_empty'));
    $success = false;
}
try {
    if ($success) {
        CBTemplate::save($_POST['field'], $_POST['value'], $_POST['path']);
    }
} catch (Exception $exception) {
    $success = false;
    e($exception->getMessage());
}
echo json_encode(['msg' => getTemplateMsg(), 'success' => $success]);
