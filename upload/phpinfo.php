<?php
if (php_sapi_name() == 'cli') {
    phpinfo(INFO_ALL);
} else {
    header('HTTP/1.0 403 Forbidden');
    die();
}
