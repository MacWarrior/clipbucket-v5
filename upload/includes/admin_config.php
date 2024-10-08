<?php
define('BACK_END', true);
define('FRONT_END', false);
define('SLOGAN', 'Administration Panel');

require_once 'common.php';
ClipBucket::getInstance()->initAdminMenu();

//Including Massuploader Class,
require_once DirPath::get('classes') . 'mass_upload.class.php';
require_once DirPath::get('classes') . 'ads.class.php';

global $Smarty, $myquery;

$cbmass = new mass_upload();
$ads_query = new AdsManager();

if (isset($_POST['update_dp_options'])) {
    if (!is_numeric($_POST['admin_pages']) || $_POST['admin_pages'] < 1) {
        $num = '20';
        $msg = 'Please Type Number from 1 to Maximum';
    } else {
        $num = $_POST['admin_pages'];
    }

    $myquery->Set_Website_Details('admin_pages', $num);
}

//Do No Edit Below This Line
define('TEMPLATEDIR', DirPath::get('admin_area') . DIRECTORY_SEPARATOR . 'styles' . DIRECTORY_SEPARATOR . 'cb_2014');
define('SITETEMPLATEDIR', DirPath::get('styles') . config('template_dir'));
define('TEMPLATEURL', DirPath::getUrl('admin_area') . 'styles' . DIRECTORY_SEPARATOR . 'cb_2014');
define('TEMPLATEURLFO', DirPath::getUrl('styles') . ClipBucket::getInstance()->template);
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
define('TEMPLATE', config('template_dir'));

require_once TEMPLATEDIR . DIRECTORY_SEPARATOR . 'header.php';

if( THIS_PAGE != 'system_info' && php_sapi_name() != 'cli' ){
    if( !System::check_global_configs() ){
        e(lang('error_server_config', '/admin_area/system_info.php#hosting'), 'w', false);
    }
}

Assign('baseurl', BASEURL);
Assign('imageurl', TEMPLATEURL . '/images');
Assign('image_url', TEMPLATEURL . '/layout');
Assign('layout', TEMPLATEURL . '/layout');
Assign('layout_url', TEMPLATEURL . '/layout');
Assign('theme', TEMPLATEURL . '/theme');
Assign('theme_url', TEMPLATEURL . '/theme');
Assign('style_dir', LAYOUT);
Assign('layout_dir', LAYOUT);
Assign('logged_user', @$_SESSION['username']);
Assign('superadmin', @$_SESSION['superadmin']);

//Including Plugins
include('plugins.php');

$Smarty->assign_by_ref('cbmass', $cbmass);

cb_call_functions('clipbucket_init_completed');
