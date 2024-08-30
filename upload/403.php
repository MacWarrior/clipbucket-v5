<?php
define('THIS_PAGE', '403');
global $cbvid;
require 'includes/config.inc.php';

if (file_exists(LAYOUT . '/403.html')) {
    template_files('403.html');
} else {
    $data = '403_error';
    if (has_access('admin_access')) {
        e(lang('err_warning', ['403', 'http://docs.clip-bucket.com/?p=154']), 'w');
    }
    e(lang($data));
}

display_it();
