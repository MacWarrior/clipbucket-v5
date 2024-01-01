<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

Language::restore_lang($_POST['code']);

display_language_list();
