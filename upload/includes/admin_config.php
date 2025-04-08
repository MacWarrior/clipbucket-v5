<?php
define('BACK_END', true);
define('FRONT_END', false);
define('SLOGAN', 'Administration Panel');

require_once 'common.php';

if( THIS_PAGE != 'admin_login' && php_sapi_name() !== 'cli'){
    if (!User::getInstance()->isUserConnected()) {
        redirect_to('login.php');
    }

    if( !User::getInstance()->hasPermission('admin_access') ){
        redirect_to(cblink(['name' => 'error_403']));
    }
}

if( !in_array(THIS_PAGE, ['update_info', 'admin_launch_update']) && php_sapi_name() != 'cli' && User::getInstance()->isUserConnected() ) {
    ClipBucket::getInstance()->initAdminMenu();
}

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
define('TEMPLATEDIR', DirPath::get('admin_area') . 'styles' . DIRECTORY_SEPARATOR . 'cb_2014');
define('SITETEMPLATEDIR', DirPath::get('styles') . config('template_dir'));
define('TEMPLATEURL', DirPath::getUrl('admin_area') . 'styles/cb_2014');
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
define('TEMPLATE', config('template_dir'));

require_once TEMPLATEDIR . DIRECTORY_SEPARATOR . 'header.php';

if( !in_array(THIS_PAGE, ['system_info', 'update_info', 'admin_launch_update']) && php_sapi_name() != 'cli' ){
    $check_global = System::check_global_configs();
    if( $check_global !== 1 ){
        if ($check_global === -1 ) {
            e(lang('error_server_config', '/admin_area/setting_basic.php#config_hosting'), 'w', false);
        } else {
            e(lang('error_server_config', '/admin_area/system_info.php#hosting'), 'w', false);
        }
    }
}

Assign('baseurl', DirPath::getUrl('root'));
Assign('imageurl', TEMPLATEURL . '/images');
Assign('image_url', TEMPLATEURL . '/layout');
Assign('layout', TEMPLATEURL . '/layout');
Assign('layout_url', TEMPLATEURL . '/layout');
Assign('theme', TEMPLATEURL . '/theme');
Assign('theme_url', TEMPLATEURL . '/theme');
Assign('style_dir', LAYOUT);
Assign('layout_dir', LAYOUT);

//Including Plugins
include('plugins.php');

$Smarty->assign_by_ref('cbmass', $cbmass);

cb_call_functions('clipbucket_init_completed');
