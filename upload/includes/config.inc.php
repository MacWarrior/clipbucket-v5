<?php
define('FRONT_END', true);
define('BACK_END', false);

if (!defined('PARENT_PAGE')) {
    define('PARENT_PAGE', 'home');
}

require_once 'common.php';
require_once 'plugins.php';

global $Cbucket, $cbvid, $ClipBucket, $userquery;

define('TEMPLATEDIR', BASEDIR . DIRECTORY_SEPARATOR . TEMPLATEFOLDER . DIRECTORY_SEPARATOR . $Cbucket->template);
define('TEMPLATEURL', '/' . TEMPLATEFOLDER . '/' . $Cbucket->template);
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
define('COVERS_DIR', BASEDIR . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'cover_photos');
Assign('baseurl', BASEURL);
Assign('imageurl', TEMPLATEURL . '/images');
Assign('layout', TEMPLATEURL . '/layout');
Assign('theme', TEMPLATEURL . '/theme');
Assign('template_dir', TEMPLATEDIR);
Assign('style_dir', LAYOUT);
Assign('covers_dir', COVERS_DIR);
Assign('admin_baseurl', '/' . ADMINDIR . '/');

//Checking Website is closed or not
if (config('closed') && THIS_PAGE != 'ajax' && !$in_bg_cron && THIS_PAGE != 'cb_install') {
    if (!has_access('admin_access', true)) {
        e($row['closed_msg'], 'w');
        template('global_header.html');
        template('message.html');
        exit();
    }
    e(lang('website_offline'), 'w');
}

//Configuring Uploader
uploaderDetails();
isSectionEnabled(PARENT_PAGE, true);

//setting quicklist

cb_call_functions('clipbucket_init_completed');

if (!$in_bg_cron && !in_array(THIS_PAGE, $ClipBucket->public_pages)) {
    if ($Cbucket->configs['access_to_logged_in'] == 'yes') {
        $userquery->logincheck();
    }
}
