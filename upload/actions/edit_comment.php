<?php
require_once '../includes/admin_config.php';
global $userquery, $myquery;

$userquery->admin_login_check();

$cid = $_POST['id'];
$value = $_POST['value'];

$myquery->update_comment($cid, $value);

echo display_clean($value);
