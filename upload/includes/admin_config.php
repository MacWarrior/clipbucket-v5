<?php
define('BACK_END', true);
define('FRONT_END', false);
define('SLOGAN', 'Administration Panel');

//Admin Area
$admin_area = true;

/* Config.Inc.php */
include('common.php');
global $ClipBucket;
$ClipBucket->initAdminMenu();

//Including Massuploader Class,
require_once('classes/mass_upload.class.php');
require_once('classes/ads.class.php');

global $db, $ClipBucket, $Cbucket, $Smarty, $myquery;

$cbmass = new mass_upload();
$ads_query = new AdsManager();

$admin_pages = $row['admin_pages'];

if (isset($_POST['update_dp_options'])) {
    if (!is_numeric($_POST['admin_pages']) || $_POST['admin_pages'] < 1) {
        $num = '20';
        $msg = 'Please Type Number from 1 to Maximum';
    } else {
        $num = $_POST['admin_pages'];
        $admin_pages = $num;
    }

    $myquery->Set_Website_Details('admin_pages', $num);
}

define('RESULTS', $admin_pages);
Assign('admin_pages', $admin_pages);

//Do No Edit Below This Line
define('ADMIN_TEMPLATE', 'cb_2014');
define('TEMPLATEDIR', DirPath::get('admin_area') . DIRECTORY_SEPARATOR . TEMPLATEFOLDER . DIRECTORY_SEPARATOR . ADMIN_TEMPLATE);
define('SITETEMPLATEDIR', DirPath::get('styles') . $row['template_dir']);
define('TEMPLATEURL', DirPath::getUrl('admin_area') . TEMPLATEFOLDER . DIRECTORY_SEPARATOR . ADMIN_TEMPLATE);
define('TEMPLATEURLFO', DirPath::getUrl('styles') . $Cbucket->template);
define('LAYOUT', TEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout');
define('TEMPLATE', $row['template_dir']);


require_once TEMPLATEDIR . DIRECTORY_SEPARATOR . 'header.php';
/*
* Calling this function to check server configs
* Checks : MEMORY_LIMIT, UPLOAD_MAX_FILESIZE, POST_MAX_SIZE, MAX_EXECUTION_TIME
* If any of these configs are less than required value, warning is shown
*/
check_server_confs();

Assign('baseurl', BASEURL);
Assign('admindir', DirPath::getUrl('admin_area'));
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
