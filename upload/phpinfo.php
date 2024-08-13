<?php
if (php_sapi_name() == 'cli') {
    if( !in_array('install', $argv) ) {
        define('THIS_PAGE', 'phpinfo');
        require 'includes/config.inc.php';
    }
    phpinfo(INFO_ALL);
    echo 'CurrentDatetime => ' . date('Y-m-d H:i:s');
} else {
    header('HTTP/1.0 403 Forbidden');
    die();
}
