<?php
require_once '../includes/admin_config.php';
global $userquery,$pages;
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = array('title' => 'Tool Box', 'url' => '');
$breadcrumb[1] = array('title' => 'Development Mode', 'url' => ADMIN_BASEURL.'/dev_mode.php');

define('DEVFILE', TEMP_DIR.'/development.dev');
if (isset($_GET))
{
    $action = $_GET['enable'];
    $data = $_GET['devpower'];
    if ($action == 'yes')
    {
        if (is_writable(BASEDIR.'/includes'))
        {
            file_put_contents(DEVFILE, $data);
            if (file_exists(DEVFILE)) {
                assign('devmsg','Development has been enabled successfuly');
            }
        } else {
            assign('deverror','"includes" directory is not writeable');
        }
    } elseif ($action == 'no') {
        unlink(DEVFILE);
        if (!file_exists(DEVFILE)) {
            assign('devmsg','Development has been disabled successfuly');
        }
    }
}

if( in_dev() )
{
    $devpower = file_get_contents(DEVFILE);
    assign('devpower',$devpower);
    assign('devmode','yes');
} else {
    assign('devmode','no');
}

subtitle('Development Mode');
template_files('dev_mode.html');
display_it();
