<?php
define('BACK_END', true);
define('FRONT_END', false);
define('SLOGAN', 'Administration Panel');

require_once 'common.php';

if( THIS_PAGE != 'admin_login' && php_sapi_name() !== 'cli'){
    if (!User::getInstance()->isUserConnected()) {
        redirect_to('login.php');
    }

    if( defined('IS_AJAX') && IS_AJAX ){
        User::getInstance()->hasPermissionAjax('admin_access');
    }

    if( !User::getInstance()->hasPermission('admin_access') ){
        redirect_to(cblink(['name' => 'error_403']));
    }
}

if( !defined('IS_AJAX') && !defined('IS_SSE') && php_sapi_name() != 'cli' && User::getInstance()->isUserConnected() ) {
    ClipBucket::getInstance()->initAdminMenu();
}

//Including Massuploader Class,
require_once DirPath::get('classes') . 'mass_upload.class.php';
require_once DirPath::get('classes') . 'ads.class.php';

global $Smarty;

$cbmass = new mass_upload();
$ads_query = new AdsManager();

//Do No Edit Below This Line
define('TEMPLATEDIR', DirPath::get('admin_area') . 'styles' . DIRECTORY_SEPARATOR . 'cb_2014');
define('SITETEMPLATEDIR', DirPath::get('styles') . config('template_dir'));
define('TEMPLATEURL', DirPath::getUrl('admin_area') . 'styles/cb_2014');
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
define('TEMPLATE', config('template_dir'));

require_once TEMPLATEDIR . DIRECTORY_SEPARATOR . 'header.php';

if (!defined('IS_AJAX') && !defined('IS_SSE') && php_sapi_name() != 'cli') {
    $check_global = System::check_global_configs();
    if ($check_global !== 1) {
        if ($check_global === -1) {
            e(lang('error_server_config', DirPath::getUrl('admin_area') . 'setting_advanced.php#config_hosting'), 'w', false);
        } else {
            e(lang('error_server_config', DirPath::getUrl('admin_area') . 'system_info.php#hosting'), 'w', false);
        }
    }
    if (System::getPHPVersionWeb() < '8.1' && !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
        e(lang('error_php_version', System::getPHPVersionWeb()), 'w');
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
