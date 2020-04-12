<?php
require_once '../includes/admin_config.php';
$userquery->admin_login_check();

$phrase_id = $_POST['pk'];
$value = $_POST['value'];

$lang_obj->update_phrase($phrase_id,$value);

echo ($value);
