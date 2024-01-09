<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

//Making Language Default
if (!empty($_POST['make_default'])) {
    $id = $_POST['make_default'];
    Language::getInstance()->make_default($id);
}

display_language_list();