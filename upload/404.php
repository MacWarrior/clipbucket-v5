<?php
define('THIS_PAGE', '404');
require 'includes/config.inc.php';

if (file_exists(LAYOUT . '/404.html')) {
    template_files('404.html');
} else {
    $data = '404_error';
    if (User::getInstance()->hasAdminAccess()) {
        e(lang('err_warning', ['404', 'http://docs.clip-bucket.com/?p=154']), 'w');
    }
    e(lang($data));
}

display_it();
