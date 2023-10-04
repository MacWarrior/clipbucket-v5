<?php
/*
* File is used for uploading logo in ClipBucket
*/

require_once '../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Update Logos', 'url' => ADMIN_BASEURL . '/upload_logo.php'];

// Upload and Rename File
if (isset($_POST['submit_logo'])) {
    // function used to upload site logo.
    upload_image('logo');
} else {
    if (isset($_POST['submit_favicon'])) {
        // function used to upload site logo.
        upload_image('favicon');
    }
}

subtitle("Update Logos");
template_files('upload_logo.html');
display_it();
