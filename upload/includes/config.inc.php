<?php
define('FRONT_END', true);
define('BACK_END', false);

if (!defined('PARENT_PAGE')) {
    define('PARENT_PAGE', 'home');
}

require_once 'common.php';
require_once 'plugins.php';

define('TEMPLATEDIR', DirPath::get('styles') . ClipBucket::getInstance()->template);
define('TEMPLATEURL', DirPath::getUrl('styles') . ClipBucket::getInstance()->template);
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
Assign('baseurl', BASEURL);
Assign('imageurl', TEMPLATEURL . '/images');
Assign('layout', TEMPLATEURL . '/layout');
Assign('theme', TEMPLATEURL . '/theme');
Assign('template_dir', TEMPLATEDIR);
Assign('style_dir', LAYOUT);

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
$need_to_active_membership = false;
if (config('enable_membership') == 'yes' && !empty(user_id())) {

    $memberships = Membership::getInstance()->getAll([
        'user_level_id' => User::getInstance()->getCurrentUserUserLevelID(),
        'is_disabled'   => false
    ]);
    if (!empty($memberships)) {
        $resutls = Membership::getInstance()->getAll([
            'first_only'          => true,
            'date_between'        => date('Y-m-d H:i:s'),
            'user_level_id'       => User::getInstance()->getCurrentUserUserLevelID(),
            'get_user_membership' => true
        ]);
        $need_to_active_membership = empty($resutls);
    }
}
assign('need_to_active_membership', $need_to_active_membership);
//setting quicklist

cb_call_functions('clipbucket_init_completed');

if (!$in_bg_cron && !in_array(THIS_PAGE, ClipBucket::getInstance()->public_pages)) {
    if (ClipBucket::getInstance()->configs['access_to_logged_in'] == 'yes') {
        userquery::getInstance()->logincheck();
    }
}
