<?php
define('THIS_PAGE', '404');
require 'includes/config.inc.php';

if (file_exists(LAYOUT . '/404.html')) {
    template_files('404.html');
} else {
    $data = '404_error';
    e(lang($data));
}

display_it();
