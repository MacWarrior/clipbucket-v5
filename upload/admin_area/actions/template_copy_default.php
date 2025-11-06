<?php
const THIS_PAGE = 'template_copy_default';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$success = true;
try {
    CBTemplate::duplicate_default_theme();
} catch (Exception $exception) {
    $success = false;
}
echo json_encode(['msg' => getTemplateMsg(), 'success' => $success]);