<?php
const THIS_PAGE = 'advanced_settings';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$permission = 'advanced_settings';
if( !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '275') ){
    $permission = 'web_config_access';
}
User::getInstance()->hasPermissionOrRedirect($permission,true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('configurations'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('advanced_settings'),
    'url'   => DirPath::getUrl('admin_area') . 'setting_advanced.php'
];

if (@$_GET['msg']) {
    $msg = mysql_clean($_GET['msg']);
}

if (isset($_POST['update'])) {
    $config_booleans = [
        'stay_mp4',
        'delete_mass_upload',
        'enable_video_file_upload',
        'enable_video_remote_play',
        'enable_photo_file_upload',
        'send_comment_notification',
        'approve_video_notification',
        'smtp_auth',
        'proxy_enable',
        'proxy_auth',
        'cache_enable',
        'cache_auth',
        'disable_email',
        'only_keep_max_resolution',
        'enable_chunk_upload',
        'photo_enable_nsfw_check',
        'video_enable_nsfw_check',
        'store_guest_session',
        'keep_ratio_photo'
    ];

    $config_booleans_to_refactor = [
        'chromecast_fix',
        'force_8bits',
        'keep_audio_tracks',
        'keep_subtitles',
        'extract_subtitles'
    ];

    $rows = [
        'allowed_video_types',
        'allowed_photo_types',
        'approve_video_notification',
        'audio_codec',
        'chromecast_fix',
        'force_8bits',
        'keep_audio_tracks',
        'keep_subtitles',
        'extract_subtitles',
        'conversion_type',

        'ffmpegpath',

        'ffprobe_path',
        'media_info',

        'max_bg_size',
        'max_conversion',
        'max_profile_pic_size',
        'max_upload_size',
        'max_video_duration',

        'num_thumbs',

        'php_path',
        'git_path',
        'max_photo_size',

        'send_comment_notification',
        'sbrate',
        'srate',
        'disable_email',

        'enable_chunk_upload',
        'chunk_upload_size',
        'cloudflare_upload_limit',

        'video_codec',
        'vrate',
        'delete_mass_upload',
        'stay_mp4',
        'enable_video_file_upload',
        'enable_video_remote_play',
        'enable_photo_file_upload',

        'allow_conversion_1_percent',

        'mail_type',
        'smtp_host',
        'smtp_user',
        'smtp_pass',
        'smtp_auth',
        'smtp_port',

        'proxy_enable',
        'proxy_auth',
        'proxy_url',
        'proxy_port',
        'proxy_username',
        'proxy_password',

        'cache_enable',
        'cache_auth',
        'cache_host',
        'cache_port',
        'cache_password',

        'only_keep_max_resolution',
        'nginx_path',
        'automate_launch_mode',
        'timezone',
        'photo_enable_nsfw_check',
        'video_enable_nsfw_check',
        'photo_nsfw_check_model',
        'video_nsfw_check_model',
        'email_sender_address',
        'email_sender_name',
        'photo_nsfw_check_model',
        'video_nsfw_check_model',
        'base_url',
        'video_nsfw_check_model',
        'thumb_background_color',
        'subtitle_format',
        'store_guest_session',
        'photo_ratio',
        'photo_lar_width',
        'photo_crop',
        'photo_thumb_width',
        'photo_thumb_height',
        'photo_med_width',
        'photo_med_height',

        'maximum_allowed_subtitle_size',
        'keep_ratio_photo'
    ];

    foreach (Upload::getInstance()->get_upload_options() as $optl) {
        if( !empty($optl['load_func']) ){
            $rows[] = $optl['load_func'];
        }
    }

    //Numeric Array
    $num_array = [
        'max_upload_size',
        'max_photo_size',
        'chunk_upload_size',
        'cloudflare_upload_limit',
        'option_maximum_allowed_subtitle_size'
    ];

    foreach ($rows as $field) {
        $value = ($_POST[$field]);
        if (in_array($field, $num_array)) {
            if ($value <= 0 || !is_numeric($value)) {
                $value = 1;
            }
        }
        if (in_array($field, $config_booleans)) {
            if ($value != 'yes') {
                $value = 'no';
            }
        }
        if (in_array($field, $config_booleans_to_refactor)) {
            if ($value != '1') {
                $value = '0';
            }
        }

        myquery::getInstance()->Set_Website_Details($field, $value);
    }

    //clear cache
    CacheRedis::flushAll();
    unset($_SESSION['check_global_configs']);

    myquery::getInstance()->saveVideoResolutions($_POST);
    e('Website settings have been updated', 'm');

    //reset permissions check cache
    if (isset($_SESSION['folder_access'])) {
        unset($_SESSION['folder_access']);
    }
}

$row = myquery::getInstance()->Get_Website_Details();
Assign('row', $row);

$video_resolutions = myquery::getInstance()->getVideoResolutions();
Assign('video_resolutions', $video_resolutions);

$ffmpeg_version = System::get_software_version('ffmpeg');
Assign('ffmpeg_version', $ffmpeg_version);

subtitle(lang('advanced_settings'));

if (!empty($_POST)) {
    $filepath_dev_file = DirPath::get('temp') . 'development.dev';
    if (!empty($_POST['enable_dev_mode'])) {
        if (is_writable(DirPath::get('temp'))) {
            file_put_contents($filepath_dev_file, '');
            if (file_exists($filepath_dev_file)) {
                System::setInDev(true);
            }
        } else {
            e('"temp" directory is not writeable');
        }
    } else {
        unlink($filepath_dev_file);
        if (!file_exists($filepath_dev_file)) {
            System::setInDev(false);
        }
    }

    if (!empty($_POST['discord_webhook_url']) && $_POST['discord_error_log'] == 'yes') {
        if (!filter_var($_POST['discord_webhook_url'], FILTER_VALIDATE_URL) || !str_starts_with($_POST['discord_webhook_url'], 'https://discord.com/')) {
            e(lang('discord_webhook_url_invalid'));
        } else {
            DiscordLog::getInstance()->enable($_POST['discord_webhook_url']);
        }
    } else {
        DiscordLog::getInstance()->disable();
    }
}

assign('discord_error_log', DiscordLog::getInstance()->isEnabled());
assign('discord_webhook_url', DiscordLog::getInstance()->getCurrentUrl());

if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367', true)) {
    $tool = AdminTool::getToolByCode('automate');
}
if (!empty($tool)) {
    $id_tool_automate = $tool['id_tool'];
    $cron_line = '* * * * * ' . System::get_binaries('php_cli') . ' -q ' . DirPath::get('admin_actions') . 'tool_launch.php id_tool=' . (int)$id_tool_automate;
}
assign('cron_copy_paste', $cron_line ?? '');

$allTimezone = [];
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '99')) {
    $query = /** @lang MySQL */
        'SELECT timezones.timezone
                            FROM ' . cb_sql_table('timezones') . '
                            ORDER BY timezones.timezone';
    $rs = Clipbucket_db::getInstance()->_select($query);
    $allTimezone = array_column($rs, 'timezone');
}
assign('allTimezone', $allTimezone);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'jquery-ui-1.13.2.min.js' => 'global'
    ,
    'pages/main/main' . $min_suffixe . '.js' => 'admin'
]);
template_files('setting_advanced.html');
display_it();
