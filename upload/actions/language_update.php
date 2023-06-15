<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

Language::update_lang($_POST);

display_language_edit();