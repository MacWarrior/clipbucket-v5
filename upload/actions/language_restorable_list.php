<?php
require_once '../includes/admin_config.php';
global $userquery;

$userquery->admin_login_check();

display_restorable_language_list();
