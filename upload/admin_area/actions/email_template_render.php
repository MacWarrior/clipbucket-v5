<?php
const THIS_PAGE = 'admin_email_template_render';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('libs') . 'htmlpurifier' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'HTMLPurifier.auto.php';
User::getInstance()->hasPermissionOrRedirect('email_template_management');

$content = $_POST['email_content'] ?? '';
$plain_text = ($_POST['format'] ?? '') === 'txt';
if (!is_string($content) || ($plain_text && !EmailTemplate::supportsPlainText())) {
    echo json_encode([
        'success' => false,
        'msg'     => lang('technical_error')
    ]);
    exit;
}

$render = EmailTemplate::renderEmailContent($content, '', [], $plain_text);
echo json_encode([
    'success'      => true,
    'email_render' => $plain_text ? $render : EmailTemplate::purify($render)
]);
