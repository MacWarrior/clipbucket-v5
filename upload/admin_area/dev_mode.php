<?php
define('THIS_PAGE', 'dev_mode');

require_once '../includes/admin_config.php';
global $userquery, $pages;
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Tool Box', 'url' => ''];
$breadcrumb[1] = ['title' => 'Development Mode', 'url' => ADMIN_BASEURL . '/dev_mode.php'];

$filepath_dev_file = TEMP_DIR . '/development.dev';
if (!empty($_POST)) {
    if (!in_dev()) {
        if (is_writable(BASEDIR . '/includes')) {
            file_put_contents($filepath_dev_file, '');
            if (file_exists($filepath_dev_file)) {
                assign('development_mode', true);
                assign('devmsg', 'Development has been enabled successfuly');
            }
        } else {
            assign('deverror', '"includes" directory is not writeable');
        }
    } else {
        unlink($filepath_dev_file);
        if (!file_exists($filepath_dev_file)) {
            assign('development_mode', false);
            assign('devmsg', 'Development has been disabled successfuly');
        }
    }
} else {
    assign('development_mode', in_dev());
}

subtitle('Development Mode');
template_files('dev_mode.html');
display_it();
