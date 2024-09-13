<?php
define('THIS_PAGE', 'upload_logo');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('update_logos'), 'url' => DirPath::getUrl('admin_area') . 'upload_logo.php'];

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

subtitle('Update Logos');
template_files('upload_logo.html');
display_it();
