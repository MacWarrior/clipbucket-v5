<?php
define('FRONT_END', true);
define('BACK_END', false);

if (!defined('PARENT_PAGE')) {
    define('PARENT_PAGE', 'home');
}

require_once 'common.php';

define('TEMPLATEDIR', DirPath::get('styles') . ClipBucket::getInstance()->template);
define('TEMPLATEURL', DirPath::getUrl('styles') . ClipBucket::getInstance()->template);
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
Assign('baseurl', Network::get_server_url());
Assign('imageurl', TEMPLATEURL . '/images');
Assign('layout', TEMPLATEURL . '/layout');
Assign('theme', TEMPLATEURL . '/theme');
Assign('template_dir', TEMPLATEDIR);
Assign('style_dir', LAYOUT);

require_once 'plugins.php';

//Checking Website is closed or not
if (config('closed') && THIS_PAGE != 'ajax' && !$in_bg_cron && THIS_PAGE != 'cb_install' && THIS_PAGE != 'signup') {
    e(config('closed_msg'), 'w');
    if (!User::getInstance()->hasAdminAccess()) {
        template('global_header.html');
        template('msg.html');
        exit();
    }
    e(lang('website_offline'), 'w');
}

//Configuring Uploader
uploaderDetails();
isSectionEnabled(PARENT_PAGE, true);

//setting quicklist
cb_call_functions('clipbucket_init_completed');

if (!$in_bg_cron && !in_array(THIS_PAGE, ClipBucket::getInstance()->public_pages)) {
    if (ClipBucket::getInstance()->configs['access_to_logged_in'] == 'yes') {
        User::getInstance()->isUserConnectedOrRedirect();
    }
}
