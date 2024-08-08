<?php
define('THIS_PAGE', 'add_custom_fields');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

if (isset($_POST['add_field'])) {
    $array = $_POST;
    $array['add_field'] = '';
    add_custom_field($array);
}

Assign('msg', @$msg);
Template('header.html');
Template('leftmenu.html');
Template('message.html');
Template('add_custom_fields.html');
Template('footer.html');
