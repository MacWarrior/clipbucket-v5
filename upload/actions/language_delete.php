<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

Language::delete_lang($_POST['language_id']);
display_language_list();