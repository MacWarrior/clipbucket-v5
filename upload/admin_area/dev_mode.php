<?php
define('THIS_PAGE','dev_mode');

require_once '../includes/admin_config.php';
global $userquery,$pages;
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Tool Box', 'url' => ''];
$breadcrumb[1] = ['title' => 'Development Mode', 'url' => ADMIN_BASEURL.'/dev_mode.php'];

$filepath_dev_file = TEMP_DIR.'/development.dev';
if (isset($_GET)) {
    $action = $_GET['enable'];
    $data = $_GET['devpower'];
    if ($action == 'yes') {
        if (is_writable(BASEDIR.'/includes')) {
            file_put_contents($filepath_dev_file, $data);
            if (file_exists($filepath_dev_file)) {
                assign('devmsg','Development has been enabled successfuly');
            }
        } else {
            assign('deverror','"includes" directory is not writeable');
        }
    } elseif ($action == 'no') {
        unlink($filepath_dev_file);
        if (!file_exists($filepath_dev_file)) {
            assign('devmsg','Development has been disabled successfuly');
        }
    }
}

if( in_dev() ) {
    $devpower = file_get_contents($filepath_dev_file);
    assign('devpower',$devpower);
    assign('devmode','yes');
} else {
    assign('devmode','no');
}

subtitle('Development Mode');
template_files('dev_mode.html');
display_it();
