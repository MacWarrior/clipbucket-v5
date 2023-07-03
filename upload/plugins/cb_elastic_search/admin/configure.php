<?php
if (!defined('IN_CLIPBUCKET')) {
    exit('Invalid access');
}

$rows = ["elastic_server_ip"];
if (isset($_POST['submit'])) {
    foreach ($rows as $field) {
        $value = ($_POST[$field]);
        if (in_array($field, $num_array)) {
            if ($value <= 0 || !is_numeric($value)) {
                $value = 1;
            }
        }
        $myquery->Set_Website_Details($field, $value);
    }
}

$template = 'configure.html';
template_files($template, CB_ES_ADMIN_DIR);
