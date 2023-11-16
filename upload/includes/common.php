<?php
ob_start();
const IN_CLIPBUCKET = true;

//Setting Cookie Timeout
const COOKIE_TIMEOUT = 86400 * 1; // 1
const GARBAGE_TIMEOUT = COOKIE_TIMEOUT;
const REMBER_DAYS = 7;

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

if (file_exists(dirname(__FILE__) . '/../files/temp/development.dev')) {
    define('DEVELOPMENT_MODE', true);
    $__devmsgs = [
        'insert_queries'        => [],
        'select_queries'        => [],
        'update_queries'        => [],
        'delete_queries'        => [],
        'count_queries'         => [],
        'execute_queries'       => [],
        'insert'                => '0',
        'select'                => '0',
        'update'                => '0',
        'delete'                => '0',
        'count'                 => '0',
        'execute'               => '0',
        'total_queries'         => '0',
        'total_query_exec_time' => '0',
        'total_memory_used'     => '0',
        'expensive_query'       => '',
        'cheapest_query'        => '',
        'total_cached_queries'  => '0'
    ];

    if (php_sapi_name() != 'cli') {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        // Keep errors in php errors log file
        $whoops->pushHandler(function($e){
            error_log($e->getMessage().PHP_EOL.$e->getTraceAsString());
        });

        $whoops->register();
    }
} else {
    define('DEVELOPMENT_MODE', false);
}

if (!@$in_bg_cron) {
    //Setting Session Max Life
    ini_set('session.gc_maxlifetime', GARBAGE_TIMEOUT);
    session_set_cookie_params(COOKIE_TIMEOUT, '/');
    session_start();
}


require_once('functions.php');
require_once('classes/db.class.php');
require_once('classes/rediscache.class.php');
require_once('classes/update.class.php');
require_once('classes/plugin.class.php');

# file with most frequently used functions

include_once('clipbucket.php');
check_install('before');

if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php'; // New config file
} else {
    require_once 'dbconnect.php'; // Old config file
}

# class for storing common ClipBucket functions
require_once('classes/ClipBucket.class.php');
require_once('classes/columns.class.php');
require_once('classes/my_queries.class.php');
require_once('classes/actions.class.php');
require_once('classes/category.class.php');
require_once('classes/user.class.php');
require_once('classes/lang.class.php');
require_once('classes/pages.class.php');
require_once('classes/tags.class.php');

$cb_columns = new cb_columns();
$myquery = new myquery();
$row = $myquery->Get_Website_Details();

if (!in_dev()) {
    define('DEBUG_LEVEL', 0);
} else {
    define('DEBUG_LEVEL', 2);
}

switch (DEBUG_LEVEL) {
    case 0:
        error_reporting(0);
        ini_set('display_errors', '0');
        break;

    case 1:
        error_reporting(E_ALL ^ E_NOTICE);
        ini_set('display_errors', 'on');
        break;

    case 2:
    default:
        error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
        ini_set('display_errors', 'on');
}
require_once('classes/errorhandler.class.php');
$pages = new pages();
$eh = new errorhandler();
$param_redis = ['host' => $row['cache_host'], 'port' => $row['cache_port']];

if ($row['cache_auth'] == 'yes') {
    $param_redis['password'] = $row['cache_password'];
}
try {
    $redis = new CacheRedis($row['cache_enable'], $param_redis);
} catch (Predis\Connection\ConnectionException $e) {
    $error_redis = 'Cannot connect to redis server';
} catch (Predis\Response\ServerException $e) {
    $error_redis = 'You need to authenticate to Redis server';
}

Language::getInstance()->init();
$arrayTranslations = Language::getInstance()->loadTranslations(Language::getInstance()->lang_id);
$ClipBucket = $Cbucket = new ClipBucket();
define('BASEDIR', $Cbucket->BASEDIR);
const DIR_SQL = BASEDIR . DIRECTORY_SEPARATOR . 'cb_install' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR;

$Cbucket->cbinfo = ['version' => VERSION, 'state' => STATE, 'rev' => REV];
if (!file_exists(BASEDIR . '/index.php')) {
    die('Basedir is incorrect, please set the correct basedir value in \'config\' table');
}
$baseurl = $row['baseurl'];

if (is_ssl()) {
    $baseurl = str_replace('http://', 'https://', $baseurl);
} else {
    $baseurl = str_replace('https://', 'http://', $baseurl);
}

//Removing www. as it effects SEO and updating Config
$wwwcheck = preg_match('/:\/\/www\./', $baseurl, $matches);
if (count($matches) > 0) {
    $baseurl = preg_replace('/:\/\/www\./', '://', $baseurl);
}

$clean_base = false;
if (defined('CLEAN_BASEURL')) {
    $clean_base = CLEAN_BASEURL;
}

define('BASEURL', $baseurl);

const TEMPLATEFOLDER = 'styles';                            //Template Folder Name, usually STYLES
const STYLES_DIR = BASEDIR . DIRECTORY_SEPARATOR . TEMPLATEFOLDER;

# Define Lang Select & Style Select
//Javascript Directory Name
const ADMINDIR = 'admin_area';
const ADMINBASEDIR = BASEDIR . DIRECTORY_SEPARATOR . 'admin_area';                //Admin Accessible Folder
const ADMIN_BASEURL = DIRECTORY_SEPARATOR . ADMINDIR;

# DIRECT PATHS OF VIDEO FILES
const FILES_DIR = BASEDIR . '/files';
const VIDEOS_DIR = FILES_DIR . '/videos';
const SUBTITLES_DIR = FILES_DIR . '/subtitles';
const THUMBS_DIR = FILES_DIR . '/thumbs';
const ORIGINAL_DIR = FILES_DIR . '/original';
const TEMP_DIR = FILES_DIR . '/temp';
const CON_DIR = FILES_DIR . '/conversion_queue';
const MASS_UPLOAD_DIR = FILES_DIR . '/mass_uploads';
const LOGS_DIR = FILES_DIR . '/logs';
const IMAGES_DIR = BASEDIR . '/images';
const IMAGES_URL = '/images';
const USER_THUMBS_DIR = BASEDIR . '/files/avatars';
const USER_BG_DIR = BASEDIR . '/files/backgrounds';
const ICONS_URL = '/images/icons';
const JS_URL = '/js';
const CSS_URL = '/css';

#DIRECT URL OF VIDEO FILES
const FILES_URL = BASEURL . '/files';
const VIDEOS_URL = FILES_URL . '/videos';
const SUBTITLES_URL = FILES_URL . '/subtitles';
const THUMBS_URL = FILES_URL . '/thumbs';
const PLAYER_DIR = BASEDIR . '/player';
const PLAYER_URL = '/player';

const USER_THUMBS_URL = FILES_URL . '/avatars';
const USER_BG_URL = FILES_URL . '/backgrounds';
# Defining Category Thumbs directory
const CAT_THUMB_DIR = BASEDIR . '/images/category_thumbs';
const CAT_THUMB_URL = '/images/category_thumbs';

# COLLECTIONS ICON DIR
const COLLECT_THUMBS_DIR = BASEDIR . '/images/collection_thumbs';
const COLLECT_THUMBS_URL = '/images/collection_thumbs';

# PHOTOS DETAILS
const PHOTOS_DIR = FILES_DIR . '/photos';
const PHOTOS_URL = '/files/photos';

# AVATARS DIR
const AVATARS_DIR = FILES_DIR . '/avatars';
const AVATARS_URL = '/files/avatars';

# LOGOS DIR
const LOGOS_DIR = FILES_DIR . '/logos';
const LOGOS_URL = '/files/logos';

# ADVANCE CACHING
const CACHE_DIR = BASEDIR . '/cache';

# User Feeds
const USER_FEEDS_DIR = CACHE_DIR . '/userfeeds';

# Number of activity feeds to display on channel page
const USER_ACTIVITY_FEEDS_LIMIT = 15;
const ALLOWED_CATEGORIES = 3;
# Defining Plugin Directory
const PLUG_DIR = BASEDIR . '/plugins';
const PLUG_URL = '/plugins';
const PLAYLIST_COVERS_DIR = IMAGES_DIR . '/playlist_covers';
const PLAYLIST_COVERS_URL = IMAGES_URL . '/playlist_covers';

require_once('classes/session.class.php');
$sess = new Session();
$userquery = new userquery();
$userquery->init();

if (has_access('admin_access', true) && !empty($error_redis)) {
    e($error_redis);
}

$thisurl = curPageURL();

if (!Update::isVersionSystemInstalled()) {
    define('NEED_UPDATE', true);
    if (strpos($thisurl, '/admin_area/upgrade_db.php') === false
        && strpos($thisurl, '/admin_area/logout.php') === false
        && strpos($thisurl, 'actions/upgrade_db.php') === false
        && $userquery->admin_login_check(true)) {
        header('Location: /admin_area/upgrade_db.php');
        die();
    }
} else {
    define('NEED_UPDATE', false);
}
//Setting Time Zone date_default_timezone_set
require_once('classes/search.class.php');
require_once('classes/signup.class.php');
require_once('classes/image.class.php');
require_once('classes/upload.class.php');
require_once('classes/ads.class.php');
require_once('classes/form.class.php');

require_once('classes/log.class.php');
require_once('classes/video.class.php');
require_once('classes/player.class.php');
require_once('classes/cbemail.class.php');
require_once('classes/pm.class.php');
require_once('classes/cbpage.class.php');
require_once('classes/reindex.class.php');
require_once('classes/collections.class.php');
require_once('classes/photos.class.php');
require_once('classes/cbfeeds.class.php');
require_once('classes/resizer.class.php');

require_once('classes/comments.class.php');

//Adding Gravatar
require_once('classes/gravatar.class.php');
require 'defined_links.php';

# Checking Website Template
include 'plugin.functions.php';
include 'plugins_functions.php';

$signup = new signup();
$Upload = new Upload();
$adsObj = new AdsManager();
$formObj = new formObj();

$cbplugin = new CBPlugin();

$cblog = new CBLogs();
$imgObj = new ResizeImage();
$cbvideo = $cbvid = new CBvideo();
$cbplayer = new CBPlayer();
$cbemail = new CBEmail();
$cbpm = new cb_pm();
$cbpage = new cbpage();
$cbindex = new CBreindex();
$cbcollection = new Collections();
$cbphoto = new CBPhotos();

$cbfeeds = new cbfeeds();

check_install('after');

# Holds Advertisement IDS that are being Viewed
$ads_array = [];

# Website Details
define('TITLE', $row['site_title']);
if (!defined('SLOGAN')) {
    define('SLOGAN', $row['site_slogan']);
}

# Seo URLS
define('SEO', $row['seo']); //Set yes / no

# Registration & Email Settings
define('EMAIL_VERIFICATION', $row['email_verification']);
define('ALLOW_REG', getArrayValue($row, 'allow_registration'));
define('WEBSITE_EMAIL', $row['website_email']);
define('SUPPORT_EMAIL', $row['support_email']);
define('WELCOME_EMAIL', $row['welcome_email']);
define('DATE_FORMAT', config('date_format'));

# Listing Of Videos , Channels
define('VLISTPP', $row['videos_list_per_page']);                //Video List Per page
define('CLISTPP', $row['channels_list_per_page']);            //Channels List Per page

# Defining Photo Limits
define('MAINPLIST', $row['photo_main_list']);

# Defining Collection Limits
define('COLLPP', $row['collection_per_page']);
define('COLLIP', $row['collection_items_page']);

# Video Options
define('VIDEO_COMMENT', $row['video_comments']);
define('VIDEO_RATING', $row['video_rating']);
define('COMMENT_RATING', $row['comment_rating']);
define('VIDEO_DOWNLOAD', $row['video_download']);
define('VIDEO_EMBED', $row['video_embed']);

# Required Settings For Video Conversion
define('VBRATE', $row['vbrate']);
define('SRATE', $row['srate']);
define('SBRATE', $row['sbrate']);
define('R_HEIGHT', $row['r_height']);
define('R_WIDTH', $row['r_width']);
define('RESIZE', $row['resize']);
define('MAX_UPLOAD_SIZE', $row['max_upload_size']);
define('THUMB_HEIGHT', $row['thumb_height']);
define('THUMB_WIDTH', $row['thumb_width']);
define('PHP_PATH', $row['php_path']);

define('MAX_COMMENT_CHR', $Cbucket->configs['max_comment_chr']);
define('USER_COMMENT_OWN', $Cbucket->configs['user_comment_own']);

# SETTING PHOTO SETTING
$cbphoto->thumb_width = $row['photo_thumb_width'];
$cbphoto->thumb_height = $row['photo_thumb_height'];
$cbphoto->mid_width = $row['photo_med_width'];
$cbphoto->mid_height = $row['photo_med_height'];
$cbphoto->lar_width = $row['photo_lar_width'];
$cbphoto->cropping = $row['photo_crop'];
$cbphoto->position = $row['watermark_placement'];

define('EMBED_VDO_WIDTH', $row['embed_player_width']);
define('EMBED_VDO_HEIGHT', $row['embed_player_height']);

require BASEDIR . '/includes/classes/template.class.php';
$cbtpl = new CBTemplate();

# STOP CACHING
$cbtpl->caching = 0;

$cbvideo->init();
$cbphoto->init_photos();

$Cbucket->set_the_template();

$cbtpl->init();
require BASEDIR . '/includes/active.php';
Assign('THIS_URL', $thisurl);
define('ALLOWED_VDO_CATS', $row['video_categories']);

Assign('NEED_UPDATE', NEED_UPDATE);

# Assigning Smarty Tags & Values
Assign('PHP_PATH', PHP_PATH);
Assign('js', JS_URL);
Assign('title', TITLE);
Assign('slogan', SLOGAN);
Assign('avatardir', '/images/avatars');
Assign('whatis', getArrayValue($row, 'whatis'));
Assign('category_thumbs', CAT_THUMB_URL);
Assign('video_thumbs', THUMBS_URL);

Assign('email_verification', EMAIL_VERIFICATION);
Assign('captcha_type', $row['captcha_type']);
Assign('languages', (isset($languages)) ? $languages : false);

Assign('VIDEOS_URL', VIDEOS_URL);
Assign('THUMBS_URL', THUMBS_URL);
Assign('PLUG_URL', PLUG_URL);

#Remote and Embed
Assign('remoteUpload', $row['remoteUpload']);
Assign('embedUpload', $row['embedUpload']);

# Video Options
Assign('video_comment', $row['video_comments']);
Assign('video_rating', $row['video_rating']);
Assign('comment_rating', $row['comment_rating']);
Assign('video_download', $row['video_download']);
Assign('video_embed', $row['video_embed']);
assign('icons_url', ICONS_URL);

if (!file_exists(PLAYLIST_COVERS_DIR)) {
    mkdir(PLAYLIST_COVERS_DIR, 0777);
}

$ClipBucket->upload_opt_list = [];

if (config('enable_video_file_upload') == 'yes') {
    $ClipBucket->upload_opt_list['file_upload_div'] = [
        'title'      => lang('upload_file'),
        'function'  => 'enable_video_file_upload'
    ];
}

if (config('enable_video_remote_upload') == 'yes') {
    $ClipBucket->upload_opt_list['remote_upload_div'] = [
        'title'      => lang('remote_upload'),
        'function'  => 'enable_video_remote_upload'
    ];
}

Assign('LANG', $arrayTranslations);

# Configuration of time format
$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M';
assign('config', $config);

# Assigning Page
Assign('page', getConstant('PAGE'));

# REGISTER OBJECTS FOR SMARTY
global $Smarty;
$Smarty->assign_by_ref('pages', $pages);
$Smarty->assign_by_ref('myquery', $myquery);
$Smarty->assign_by_ref('userquery', $userquery);
$Smarty->assign_by_ref('signup', $signup);
$Smarty->assign_by_ref('Upload', $Upload);
$Smarty->assign_by_ref('db', $db);
$Smarty->assign_by_ref('adsObj', $adsObj);
$Smarty->assign_by_ref('formObj', $formObj);
$Smarty->assign_by_ref('Cbucket', $Cbucket);
$Smarty->assign_by_ref('ClipBucket', $Cbucket);
$Smarty->assign_by_ref('eh', $eh);
$Smarty->assign_by_ref('lang_obj', Language::getInstance());
$Smarty->assign_by_ref('cbvid', $cbvid);
$Smarty->assign_by_ref('cbtpl', $cbtpl);
$Smarty->assign_by_ref('cbplayer', $cbplayer);
$Smarty->assign_by_ref('cbpm', $cbpm);
$Smarty->assign_by_ref('cbpage', $cbpage);
$Smarty->assign_by_ref('cbemail', $cbemail);
$Smarty->assign_by_ref('cbcollection', $cbcollection);
$Smarty->assign_by_ref('cbphoto', $cbphoto);
$Smarty->assign_by_ref('cbfeeds', $cbfeeds);

# REGISTERING FUNCTION FOR SMARTY TEMPLATES
function show_video_rating($params)
{
    global $cbvid;
    return $cbvid->show_video_rating($params);
}

$Smarty->register_function('AD', 'getAd');
$Smarty->register_function('get_thumb', 'getSmartyThumb');
$Smarty->register_function('getThumb', 'getSmartyThumb');
$Smarty->register_function('videoLink', 'videoSmartyLink');
$Smarty->register_function('show_rating', 'show_rating');
$Smarty->register_function('ANCHOR', 'ANCHOR');
$Smarty->register_function('avatar', 'avatar');
$Smarty->register_function('load_form', 'load_form');
$Smarty->register_function('get_all_video_files', 'get_all_video_files_smarty');
$Smarty->register_function('input_value', 'input_value');
$Smarty->register_function('userid', 'user_id');
$Smarty->register_function('FlashPlayer', 'flashPlayer');
$Smarty->register_function('link', 'cblink');
$Smarty->register_function('show_share_form', 'show_share_form');
$Smarty->register_function('show_flag_form', 'show_flag_form');
$Smarty->register_function('show_playlist_form', 'show_playlist_form');
$Smarty->register_function('show_collection_form', 'show_collection_form');
$Smarty->register_function('lang', 'smarty_lang');
$Smarty->register_function('get_videos', 'get_videos');
$Smarty->register_function('get_users', 'get_users');
$Smarty->register_function('get_photos', 'get_photos');
$Smarty->register_function('get_collections', 'get_collections');
$Smarty->register_function('private_message', 'private_message');
$Smarty->register_function('show_video_rating', 'show_video_rating');
$Smarty->register_function('load_captcha', 'load_captcha');
$Smarty->register_function('cbtitle', 'cbtitle');
$Smarty->register_function('head_menu', 'head_menu');
$Smarty->register_function('foot_menu', 'foot_menu');
$Smarty->register_function('include_header', 'include_header');
$Smarty->register_function('include_template_file', 'include_template_file');
$Smarty->register_function('include_js', 'include_js');
$Smarty->register_function('include_css', 'include_css');
$Smarty->register_function('get_binaries', 'get_binaries');
$Smarty->register_function('rss_feeds', 'rss_feeds');
$Smarty->register_function('website_logo', 'website_logo');
$Smarty->register_function('get_photo', 'get_image_file');
$Smarty->register_function('uploadButton', 'upload_photo_button');
$Smarty->register_function('embedCodes', 'photo_embed_codes');
$Smarty->register_function('cbCategories', 'getSmartyCategoryList');
$Smarty->register_function('cbMenu', 'cbMenu');

$Smarty->register_modifier('SetTime', 'SetTime');
$Smarty->register_modifier('getname', 'getname');
$Smarty->register_modifier('getext', 'getext');
$Smarty->register_modifier('post_form_val', 'post_form_val');
$Smarty->register_modifier('get_thumb_num', 'get_thumb_num');
$Smarty->register_modifier('ad', 'ad');
$Smarty->register_modifier('get_user_level', 'get_user_level');
$Smarty->register_modifier('get_age', 'get_age');
$Smarty->register_modifier('outgoing_link', 'outgoing_link');
$Smarty->register_modifier('nicetime', 'nicetime');
$Smarty->register_modifier('country', 'get_country');
$Smarty->register_modifier('flag_type', 'flag_type');
$Smarty->register_modifier('get_username', 'get_username');
$Smarty->register_modifier('formatfilesize', 'formatfilesize');

assign('updateEmbedCode', 'updateEmbed');
# Registering Video Remove Functions
register_action_remove_video('remove_video_thumbs');
register_action_remove_video('remove_video_subtitles');
register_action_remove_video('remove_video_log');
register_action_remove_video('remove_video_files');
cb_register_function('plupload_photo_uploader', 'uploaderDetails');

cb_register_action('increment_playlist_played', 'view_playlist');

include('admin.functions.php');
# Other settings
define('SEND_COMMENT_NOTIFICATION', config('send_comment_notification'));
