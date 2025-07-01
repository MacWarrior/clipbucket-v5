<?php
define('THIS_PAGE', 'admin_email_template_render');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('email_template_management');

if( empty($_POST['email_content']) ){
    echo json_encode([
        'success' => false,
        'msg'     => lang('technical_error')
    ]);
    die();
}

echo json_encode([
    'success'      => true,
    'email_render' => EmailTemplate::getRenderedContent($_POST['email_content'])
]);
