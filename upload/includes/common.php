<?php
ob_start();

require_once 'constants.php';
require_once DirPath::get('vendor') . 'autoload.php';
require_once DirPath::get('classes') . 'DiscordLog.php';
require_once DirPath::get('classes') . 'WhoopsManager.php';
require_once DirPath::get('classes') . 'my_queries.class.php';

$whoops = \WhoopsManager::getInstance();
if (file_exists(DirPath::get('temp') . 'development.dev')) {
    if( !defined('DEVELOPMENT_MODE') ){
        define('DEVELOPMENT_MODE', true);
    }
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
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    }
} else {
    if( !defined('DEVELOPMENT_MODE') ) {
        define('DEVELOPMENT_MODE', false);
    }
}
$whoops->pushHandler(function($e){
    $message = 'URL : **' . $_SERVER['REQUEST_URI'] . '**' .PHP_EOL. $e->getMessage().PHP_EOL.$e->getTraceAsString();
    error_log($message);
    DiscordLog::getInstance()->error('URL : ' . $_SERVER['REQUEST_URI'], ['exception'=>$e]);
});
$whoops->register();

// Keep errors in php errors log file
$whoops->pushHandler(function($e){
    error_log($e->getMessage().PHP_EOL.$e->getTraceAsString());
});

$whoops->register();

if (!@$in_bg_cron) {
    //Setting Session Max Life
    ini_set('session.gc_maxlifetime', COOKIE_TIMEOUT);
    session_set_cookie_params(COOKIE_TIMEOUT, '/');
    session_start();
}

require_once DirPath::get('classes') . 'ClipBucket.class.php';
require_once DirPath::get('includes') . 'functions.php';
require_once DirPath::get('classes') . 'db.class.php';
require_once DirPath::get('classes') . 'rediscache.class.php';
require_once DirPath::get('classes') . 'network.class.php';

check_install('before');
if (file_exists(DirPath::get('includes') . 'config.php')) {
    require_once DirPath::get('includes') . 'config.php'; // New config file
} else {
    require_once DirPath::get('includes') . 'dbconnect.php'; // Old config file
}

require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('classes') . 'plugin.class.php';
require_once DirPath::get('classes') . 'cli.class.php';
require_once DirPath::get('classes') . 'columns.class.php';
require_once DirPath::get('classes') . 'actions.class.php';
require_once DirPath::get('classes') . 'category.class.php';
require_once DirPath::get('classes') . 'user_level.class.php';
require_once DirPath::get('classes') . 'user.class.php';
require_once DirPath::get('classes') . 'lang.class.php';
require_once DirPath::get('classes') . 'pages.class.php';
require_once DirPath::get('classes') . 'tags.class.php';
require_once DirPath::get('classes') . 'curl.class.php';
require_once DirPath::get('classes') . 'tmdb.class.php';
require_once DirPath::get('classes') . 'admin_tool.class.php';
require_once DirPath::get('classes') . 'system.class.php';
require_once DirPath::get('classes') . 'social_networks.class.php';
require_once DirPath::get('classes') . 'AIVision.class.php';
require_once DirPath::get('classes') . 'email_template.class.php';
require_once DirPath::get('classes') . 'ffmpeg.class.php';
require_once DirPath::get('classes') . 'flag.class.php';
require_once DirPath::get('classes') . 'sort_type.class.php';

$cb_columns = new cb_columns();
$row = myquery::getInstance()->Get_Website_Details();

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
        if (version_compare(System::get_software_version('php_web'), '8.4.0', '<')) {
            error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
        } else {
            error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_WARNING));
        }
        ini_set('display_errors', 'on');
}
require_once DirPath::get('classes') . 'errorhandler.class.php';
require_once DirPath::get('classes') . 'session_message_handler.class.php';

foreach (sessionMessageHandler::get_messages() as $message) {
    errorhandler::getInstance()->e($message['message'], $message['type']);
}

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

ClipBucket::getInstance()->cbinfo = ['version' => Update::getInstance()->getCurrentCoreVersion(), 'rev' => Update::getInstance()->getCurrentCoreRevision()];

$timezone = config('timezone');
if(!empty($timezone)) {
    date_default_timezone_set($timezone);
}

require_once('classes/session.class.php');
$sess = new Session();

if (User::getInstance()->hasAdminAccess() && !empty($error_redis)) {
    e($error_redis);
}

if (!Update::isVersionSystemInstalled()) {
    define('NEED_UPDATE', true);

    $request_uri = $_SERVER['REQUEST_URI'];

    if (strpos($request_uri, '/admin_area/upgrade_db.php') === false
        && strpos($request_uri, '/admin_area/logout.php') === false
        && strpos($request_uri, 'actions/upgrade_db.php') === false
        && strpos($request_uri, 'admin_area/sse/upgrade_db_info.php') === false
        && User::getInstance()->hasAdminAccess()) {
        header('Location: ' . DirPath::getUrl('admin_area') . 'upgrade_db.php');
        die();
    }
} else {
    define('NEED_UPDATE', false);
}

require_once DirPath::get('includes') . 'defined_links.php';
require_once DirPath::get('classes') . 'search.class.php';
require_once DirPath::get('classes') . 'signup.class.php';
require_once DirPath::get('classes') . 'image.class.php';
require_once DirPath::get('classes') . 'fileupload.class.php';
require_once DirPath::get('classes') . 'upload.class.php';
require_once DirPath::get('classes') . 'ads.class.php';
require_once DirPath::get('classes') . 'form.class.php';
require_once DirPath::get('classes') . 'log.class.php';
require_once DirPath::get('classes') . 'cms.class.php';
require_once DirPath::get('classes') . 'video.class.php';
require_once DirPath::get('classes') . 'playlist.class.php';
require_once DirPath::get('classes') . 'player.class.php';
require_once DirPath::get('classes') . 'cbemail.class.php';
require_once DirPath::get('classes') . 'pm.class.php';
require_once DirPath::get('classes') . 'cbpage.class.php';
require_once DirPath::get('classes') . 'reindex.class.php';
require_once DirPath::get('classes') . 'collections.class.php';
require_once DirPath::get('classes') . 'photos.class.php';
require_once DirPath::get('classes') . 'cbfeeds.class.php';
require_once DirPath::get('classes') . 'resizer.class.php';
require_once DirPath::get('classes') . 'comments.class.php';
require_once DirPath::get('classes') . 'gravatar.class.php';
require_once DirPath::get('includes') . 'plugin.functions.php';
require_once DirPath::get('includes') . 'plugins_functions.php';

$signup = new signup();
$adsObj = new AdsManager();
$formObj = new formObj();

$cbplugin = new CBPlugin();

$cblog = new CBLogs();
$imgObj = new ResizeImage();
$cbplayer = new CBPlayer();
$cbemail = new CBEmail();
$cbpm = new cb_pm();
$cbindex = new CBreindex();

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
define('DATE_FORMAT', config('date_format'));

# Defining Photo Limits
define('MAINPLIST', $row['photo_main_list']);

# Defining Collection Limits
define('COLLPP', $row['collection_per_page']);
define('COLLIP', $row['collection_items_page']);

define('MAX_COMMENT_CHR', ClipBucket::getInstance()->configs['max_comment_chr']);
define('EMBED_VDO_WIDTH', $row['embed_player_width']);
define('EMBED_VDO_HEIGHT', $row['embed_player_height']);

require DirPath::get('classes') . 'template.class.php';
$cbtpl = new CBTemplate();

# STOP CACHING
$cbtpl->caching = 0;

CBvideo::getInstance()->init();
CBPhotos::getInstance()->init_photos();

ClipBucket::getInstance()->set_the_template();

$cbtpl->init();
require DirPath::get('includes') . 'active.php';

Assign('NEED_UPDATE', NEED_UPDATE);
Assign('js', DirPath::getUrl('js'));
Assign('title', TITLE);
Assign('PLUG_URL', DirPath::getUrl('plugins'));

ClipBucket::getInstance()->upload_opt_list = [];

if (config('enable_video_file_upload') == 'yes') {
    ClipBucket::getInstance()->upload_opt_list['file_upload_div'] = [
        'title'    => lang('upload_file'),
        'function' => 'enable_video_file_upload'
    ];
}

if (config('enable_video_remote_upload') == 'yes') {
    ClipBucket::getInstance()->upload_opt_list['remote_upload_div'] = [
        'title'    => lang('remote_upload'),
        'function' => 'enable_video_remote_upload'
    ];
}

# Configuration of time format
$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M';
assign('config', $config);

# Assigning Page
Assign('page', getConstant('PAGE'));

# REGISTER OBJECTS FOR SMARTY
global $Smarty;
$Smarty->assign_by_ref('signup', $signup);
$Smarty->assign_by_ref('adsObj', $adsObj);
$Smarty->assign_by_ref('formObj', $formObj);
$Smarty->assign_by_ref('lang_obj', Language::getInstance());
$Smarty->assign_by_ref('cbtpl', $cbtpl);
$Smarty->assign_by_ref('cbplayer', $cbplayer);
$Smarty->assign_by_ref('cbpm', $cbpm);
$Smarty->assign_by_ref('cbfeeds', $cbfeeds);

# REGISTERING FUNCTION FOR SMARTY TEMPLATES
function show_video_rating($params)
{
    return CBvideo::getInstance()->show_video_rating($params);
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
$Smarty->register_function('show_player', 'show_player');
$Smarty->register_function('link', 'cblink');
$Smarty->register_function('show_share_form', 'show_share_form');
$Smarty->register_function('show_flag_form', 'show_flag_form');
$Smarty->register_function('show_playlist_form', 'show_playlist_form');
$Smarty->register_function('lang', 'smarty_lang');
$Smarty->register_function('get_videos', 'get_videos');
$Smarty->register_function('get_users', 'get_users');
$Smarty->register_function('get_photos', 'get_photos');
$Smarty->register_function('private_message', 'private_message');
$Smarty->register_function('show_video_rating', 'show_video_rating');
$Smarty->register_function('load_captcha', 'load_captcha');
$Smarty->register_function('cbtitle', 'cbtitle');
$Smarty->register_function('foot_menu', 'foot_menu');
$Smarty->register_function('include_header', 'include_header');
$Smarty->register_function('include_template_file', 'include_template_file');
$Smarty->register_function('include_js', 'include_js');
$Smarty->register_function('include_css', 'include_css');
$Smarty->register_function('rss_feeds', 'rss_feeds');
$Smarty->register_function('get_photo', 'get_image_file');
$Smarty->register_function('cbCategories', 'getSmartyCategoryList');
$Smarty->register_modifier('SetTime', 'SetTime');
$Smarty->register_modifier('getname', 'getname');
$Smarty->register_modifier('getext', 'getext');
$Smarty->register_modifier('post_form_val', 'post_form_val');
$Smarty->register_modifier('get_thumb_num', 'get_thumb_num');
$Smarty->register_modifier('ad', 'ad');
$Smarty->register_modifier('nicetime', 'nicetime');
$Smarty->register_modifier('get_username', 'get_username');
$Smarty->register_modifier('formatfilesize', 'formatfilesize');

# Registering Video Remove Functions
register_action_remove_video('remove_video_thumbs');
register_action_remove_video('remove_video_subtitles');
register_action_remove_video('remove_video_log');
register_action_remove_video('remove_video_files');
cb_register_function('plupload_photo_uploader', 'uploaderDetails');

cb_register_action('increment_playlist_played', 'view_playlist');

/** Load automatic tools from user_activity */
if(php_sapi_name() !== 'cli' && config('automate_launch_mode') == 'user_activity') {
    require_once DirPath::get('classes') .'admin_tool.class.php';
    $tool = new AdminTool();

    $dateTime = new DateTime();
    $dateTime->modify('-1 minutes');
    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
        if($tool->initByCode('automate') && $tool->getLastStart() <= $dateTime->format('Y-m-d H:i:s')) {
            AdminTool::launchCli($tool->getId());
        }
    }
}

include('admin.functions.php');
