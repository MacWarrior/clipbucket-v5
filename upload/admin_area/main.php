<?php
define('THIS_PAGE', 'website_configurations');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Website Configurations', 'url' => DirPath::getUrl('admin_area') . 'main.php'];

if (@$_GET['msg']) {
    $msg = mysql_clean($_GET['msg']);
}

$opt_list = Upload::getInstance()->get_upload_options();

assign('opt_list', $opt_list);
assign('post_max_size', ini_get('post_max_size'));
assign('upload_max_size', ini_get('upload_max_filesize'));

if (isset($_POST['update'])) {
    $config_booleans = [
        'seo'
        , 'store_guest_session'
        , 'videosSection'
        , 'photosSection'
        , 'collectionsSection'
        , 'channelsSection'
        , 'enable_advertisement'
        , 'use_cached_pagin'
        , 'gravatars'
        , 'picture_url'
        , 'picture_upload'
        , 'background_url'
        , 'background_upload'
        , 'background_color'
        , 'allow_unicode_usernames'
        , 'allow_username_spaces'
        , 'feedsSection'
        , 'stay_mp4'
        , 'delete_mass_upload'
        , 'enable_video_file_upload'
        , 'enable_video_remote_upload'
        , 'enable_photo_file_upload'
        , 'send_comment_notification'
        , 'approve_video_notification'
        , 'smtp_auth'
        , 'video_round_views'
        , 'anonym_comments'
        , 'popup_video'
        , 'proxy_enable'
        , 'proxy_auth'
        , 'cache_enable'
        , 'cache_auth'
        , 'disable_email'
        , 'enable_country'
        , 'enable_gender'
        , 'enable_user_category'
        , 'enable_rss_feeds'
        , 'enable_user_firstname_lastname'
        , 'enable_user_relation_status'
        , 'enable_user_postcode'
        , 'enable_user_hometown'
        , 'enable_user_city'
        , 'enable_user_education'
        , 'enable_user_schools'
        , 'enable_user_occupation'
        , 'enable_user_compagnies'
        , 'enable_user_hobbies'
        , 'enable_user_favorite_movies'
        , 'enable_user_favorite_music'
        , 'enable_user_favorite_books'
        , 'enable_user_website'
        , 'enable_user_about'
        , 'enable_user_status'
        , 'enable_video_social_sharing'
        , 'enable_video_internal_sharing'
        , 'enable_video_link_sharing'
        , 'enable_age_restriction'
        , 'enable_user_dob_edition'
        , 'enable_blur_restricted_content'
        , 'enable_global_age_restriction'
        , 'enable_quicklist'
        , 'hide_empty_collection'
        , 'display_video_comments'
        , 'display_photo_comments'
        , 'display_channel_comments'
        , 'enable_collection_comments'
        , 'display_collection_comments'
        , 'enable_sitemap'
        , 'enable_tmdb'
        , 'tmdb_get_genre'
        , 'tmdb_get_actors'
        , 'tmdb_get_producer'
        , 'tmdb_get_executive_producer'
        , 'tmdb_get_director'
        , 'tmdb_get_crew'
        , 'tmdb_get_poster'
        , 'tmdb_get_release_date'
        , 'tmdb_get_title'
        , 'tmdb_get_description'
        , 'tmdb_get_backdrop'
        , 'tmdb_get_age_restriction'
        , 'enable_video_genre'
        , 'enable_video_actor'
        , 'enable_video_producer'
        , 'enable_video_executive_producer'
        , 'enable_video_director'
        , 'enable_video_crew'
        , 'enable_video_poster'
        , 'enable_video_backdrop'
        , 'enable_edit_button'
        , 'enable_sub_collection'
        , 'only_keep_max_resolution'
        , 'enable_tmdb_mature_content'
        , 'tmdb_enable_on_front_end'
    ];

    $config_booleans_to_refactor = [
        'closed'
        , 'enable_update_checker'
        , 'allow_language_change'
        , 'allow_registeration'
        , 'allow_template_change'
        , 'pick_geo_country'
        , 'email_verification'
        , 'show_collapsed_checkboxes'
        , 'use_subs'
        , 'activation'
        , 'chromecast_fix'
        , 'photo_activation'
        , 'force_8bits'
        , 'video_embed'
        , 'video_download'
        , 'bits_color_warning'
        , 'video_comments'
        , 'photo_comments'
        , 'channel_comments'
        , 'video_rating'
        , 'own_video_rating'
        , 'photo_rating'
        , 'own_photo_rating'
        , 'comment_rating'
        , 'collection_rating'
        , 'own_collection_rating'
        , 'channel_rating'
        , 'own_channel_rating'
        , 'keep_audio_tracks'
        , 'keep_subtitles'
        , 'extract_subtitles'
        , 'photo_crop'
    ];

    $rows = [
        'allowed_video_types',
        'allowed_photo_types',
        'allow_language_change',
        'allow_unicode_usernames',
        'allow_username_spaces',
        'allow_registeration',
        'allow_template_change',
        'enable_advertisement',
        'allow_upload',
        'anonym_comments',
        'approve_video_notification',
        'audio_codec',
        'activation',
        'photo_activation',
        'chromecast_fix',
        'force_8bits',
        'keep_audio_tracks',
        'keep_subtitles',
        'extract_subtitles',
        'conversion_type',
        'enable_sub_collection',
        'enable_rss_feeds',

        'background_color',
        'background_upload',
        'background_url',
        'big_thumb_width',
        'big_thumb_height',
        'email_domain_restriction',

        'closed',
        'closed_msg',
        'channel_comments',
        'channels_list_per_page',
        'channelsSection',
        'channel_rating',
        'collection_rating',
        'collectionsSection',
        'comments_per_page',
        'comments_captcha',
        'comment_rating',
        'collection_per_page',
        'collection_search_result',
        'collection_items_page',
        'collection_home_top_collections',
        'collection_collection_top_collections',
        'collection_photos_top_collections',

        'date_format',
        'description',
        'default_country_iso2',
        'pick_geo_country',
        'enable_update_checker',
        'disallowed_usernames',
        'use_subs',

        'embedUpload',
        'email_verification',
        'enable_groups',

        'ffmpegpath',

        'ffprobe_path',
        'media_info',

        'gravatars',

        'keywords',
        'keep_mp4_as_is',

        'r_height',
        'r_width',

        'max_bg_width',
        'max_bg_size',
        'max_conversion',
        'max_profile_pic_size',
        'max_profile_pic_width',
        'max_video_title',
        'max_video_desc',
        'max_video_tags',
        'max_username',
        'min_video_title',
        'min_video_tags',
        'min_video_desc',
        'min_age_reg',
        'min_username',
        'max_comment_chr',
        'max_upload_size',
        'max_video_duration',

        'num_thumbs',

        'own_channel_rating',
        'own_collection_rating',
        'own_video_rating',
        'own_photo_rating',

        'php_path',
        'git_path',
        'picture_url',
        'picture_upload',
        'photosSection',
        'photo_main_list',
        'photo_home_tabs',
        'photo_search_result',
        'photo_channel_page',
        'photo_user_photos',
        'photo_user_favorites',
        'photo_other_limit',
        'photo_ratio',
        'photo_multi_upload',
        'photo_lar_width',
        'photo_crop',
        'max_photo_size',
        'photo_thumb_width',
        'photo_thumb_height',
        'photo_med_width',
        'photo_med_height',

        'resize',
        'remoteUpload',
        'recently_viewed_limit',

        'send_comment_notification',
        'site_title',
        'sys_os',
        'sbrate',
        'srate',
        'site_slogan',
        'seo',
        'seo_vido_url',
        'search_list_per_page',
        'support_email',
        'show_collapsed_checkboxes',
        'disable_email',
        'enable_country',
        'enable_gender',
        'enable_user_category',
        'enable_user_firstname_lastname',
        'enable_user_relation_status',
        'enable_user_postcode',
        'enable_user_hometown',
        'enable_user_city',
        'enable_user_education',
        'enable_user_schools',
        'enable_user_occupation',
        'enable_user_compagnies',
        'enable_user_hobbies',
        'enable_user_favorite_movies',
        'enable_user_favorite_music',
        'enable_user_favorite_books',
        'enable_user_website',
        'enable_user_about',
        'enable_user_status',
        'enable_video_social_sharing',
        'enable_video_internal_sharing',
        'enable_video_link_sharing',
        'enable_age_restriction',
        'enable_user_dob_edition',
        'enable_blur_restricted_content',
        'enable_global_age_restriction',
        'enable_collection_comments',
        'display_collection_comments',
        'enable_sitemap',

        'thumb_width',
        'thumb_height',

        'user_comment_own',
        'users_items_subscriptions',
        'users_items_contacts_channel',
        'users_items_search_page',
        'use_cached_pagin',
        'cached_pagin_time',

        'vid_categories',
        'vid_cat_height',
        'vid_cat_width',
        'videosSection',
        'videos_items_hme_page',
        'videos_items_ufav_page',
        'videos_items_uvid_page',
        'videos_items_search_page',
        'videos_item_channel_page',
        'videos_list_per_page',
        'video_download',
        'bits_color_warning',
        'video_embed',
        'video_comments',
        'photo_comments',
        'video_rating',
        'photo_rating',
        'video_categories',
        'video_codec',
        'vrate',
        'video_require_login',
        'feedsSection',
        'website_email',
        'welcome_email',
        'store_guest_session',
        'delete_mass_upload',
        'stay_mp4',
        'popup_video',
        'video_round_views',
        'enable_video_file_upload',
        'enable_video_remote_upload',
        'enable_photo_file_upload',
        'enable_quicklist',

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

        'enable_tmdb',
        'tmdb_token',
        'tmdb_get_genre',
        'tmdb_get_actors',
        'tmdb_get_producer',
        'tmdb_get_executive_producer',
        'tmdb_get_director',
        'tmdb_get_crew',
        'tmdb_get_poster',
        'tmdb_get_release_date',
        'tmdb_get_title',
        'tmdb_get_description',
        'tmdb_get_backdrop',
        'tmdb_get_age_restriction',
        'tmdb_search',
        'enable_tmdb_mature_content',
        'tmdb_mature_content_age',
        'enable_video_genre',
        'enable_video_actor',
        'enable_video_producer',
        'enable_video_executive_producer',
        'enable_video_director',
        'enable_video_crew',
        'enable_video_poster',
        'enable_video_backdrop',
        'enable_edit_button',
        'tmdb_enable_on_front_end',

        'hide_empty_collection',
        'display_video_comments',
        'display_photo_comments',
        'display_channel_comments',
        'only_keep_max_resolution'
    ];

    foreach ($opt_list as $optl) {
        $rows[] = $optl['load_func'];
    }

    //Numeric Array
    $num_array = [
        'channels_list_per_page',

        'max_upload_size',
        'max_video_title',
        'max_video_desc',
        'max_video_tags',
        'min_video_title',
        'min_video_tags',
        'min_video_desc',

        'recently_viewed_limit',

        'search_list_per_page',

        'users_items_subscriptions',
        'users_items_contacts_channel',
        'users_items_search_page',

        'videos_items_hme_page',
        'videos_items_ufav_page',
        'videos_items_uvid_page',
        'videos_items_search_page',
        'videos_item_channel_page',
        'videos_list_per_page',
        'video_categories',
        'tmdb_mature_content_age',

        'photo_main_list',
        'photo_home_tabs',
        'photo_search_result',
        'photo_channel_page',
        'photo_user_photos',
        'photo_user_favorites',
        'photo_other_limit',

        'collection_per_page',
        'collection_search_result',
        'collection_items_page',
        'collection_home_top_collections',
        'collection_collection_top_collections',
        'collection_photos_top_collections',

        'photo_multi_upload',
        'photo_lar_width',
        'max_photo_size',
        'photo_thumb_width',
        'photo_thumb_height',
        'photo_med_width',
        'photo_med_height',
    ];

    if (empty($_POST['display_video_comments']) || $_POST['display_video_comments'] == 'no') {
        $_POST['video_comments'] = '0';
    }
    if (empty($_POST['display_photo_comments']) || $_POST['display_photo_comments'] == 'no') {
        $_POST['photo_comments'] = '0';
    }
    if (empty($_POST['display_channel_comments']) || $_POST['display_channel_comments'] == 'no') {
        $_POST['channel_comments'] = '0';
    }
    if (empty($_POST['display_collection_comments']) || $_POST['display_collection_comments'] == 'no') {
        $_POST['collection_comments'] = '0';
    }
    foreach ($rows as $field) {
        $value = ($_POST[$field]);
        if (in_array($field, $num_array)) {
            if ($field == 'min_age_reg' && ($value > 99 || $value <= 0 || !is_numeric($value) )) {
                e(lang('error_age_restriction_save'));
                break;
            }
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
    CacheRedis::flushAll();

    myquery::getInstance()->saveVideoResolutions($_POST);
    e('Website settings have been updated', 'm');
}

$row = myquery::getInstance()->Get_Website_Details();
Assign('row', $row);

$video_resolutions = myquery::getInstance()->getVideoResolutions();
Assign('video_resolutions', $video_resolutions);

$ffmpeg_version = check_version('ffmpeg');
Assign('ffmpeg_version', $ffmpeg_version);

subtitle('Website Configurations');

if (!empty($_POST)) {
    $filepath_dev_file = DirPath::get('temp') . 'development.dev';
    if (!empty($_POST['enable_dev_mode'])) {
        if (is_writable(DirPath::get('temp'))) {
            file_put_contents($filepath_dev_file, '');
            if (file_exists($filepath_dev_file)) {
                assign('DEVELOPMENT_MODE', true);
            }
        } else {
            e('"temp" directory is not writeable');
        }
    } else {
        unlink($filepath_dev_file);
        if (!file_exists($filepath_dev_file)) {
            assign('DEVELOPMENT_MODE', false);
        }
    }
} else {
    assign('DEVELOPMENT_MODE', in_dev());
}

if( !empty($_POST['discord_error_log']) ){
    if (!empty($_POST['discord_webhook_url']) && $_POST['discord_error_log'] == 'yes') {
        if (!filter_var($_POST['discord_webhook_url'], FILTER_VALIDATE_URL) || strpos($_POST['discord_webhook_url'], 'https://discord.com/') !== 0) {
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

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
ClipBucket::getInstance()->addAdminJS(['jquery-ui-1.13.2.min.js' => 'global']);
ClipBucket::getInstance()->addAdminJS(['pages/main/main'.$min_suffixe.'.js' => 'admin']);
template_files('main.html');
display_it();
