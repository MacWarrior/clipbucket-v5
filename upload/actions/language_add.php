<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

Language::add_lang($_POST);

display_language_list();