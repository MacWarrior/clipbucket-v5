<?php
const THIS_PAGE = 'basic_settings';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$permission = 'basic_settings';
if( !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '275') ){
    $permission = 'web_config_access';
}
User::getInstance()->hasPermissionOrRedirect($permission,true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('basic_settings'), 'url' => DirPath::getUrl('admin_area') . 'setting_basic.php'];

if (@$_GET['msg']) {
    $msg = mysql_clean($_GET['msg']);
}

if (isset($_POST['reset_player-logo_name'])) {
    if (file_exists(DirPath::get('logos') . 'player-logo.png')) {
        unlink(DirPath::get('logos') . 'player-logo.png');
    }
    myquery::getInstance()->Set_Website_Details('player-logo_name', '');
    myquery::getInstance()->Set_Website_Details('logo_update_timestamp', time());
    e(lang('player_logo_reset'), 'm');
}

if (isset($_POST['reset_site_logo'])) {
    unlink(DirPath::get('logos') . config('logo_name'));
    myquery::getInstance()->Set_Website_Details('logo_name', '');
    myquery::getInstance()->Set_Website_Details('logo_update_timestamp', time());
    e(lang('logo_reset'), 'm');
}
if (isset($_POST['reset_site_favicon'])) {
    unlink(DirPath::get('logos') . config('favicon_name'));
    myquery::getInstance()->Set_Website_Details('favicon_name', '');
    myquery::getInstance()->Set_Website_Details('logo_update_timestamp', time());
    e(lang('favicon_reset'), 'm');
}

if (isset($_POST['update'])) {
    $config_booleans = [
        'seo'
        , 'videosSection'
        , 'photosSection'
        , 'playlistsSection'
        , 'collectionsSection'
        , 'channelsSection'
        , 'enable_advertisement'
        , 'gravatars'
        , 'picture_url'
        , 'picture_upload'
        , 'background_url'
        , 'background_upload'
        , 'background_color'
        , 'allow_unicode_usernames'
        , 'allow_username_spaces'
        , 'feedsSection'
        , 'video_round_views'
        , 'anonym_comments'
        , 'popup_video'
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
        , 'enable_hide_uploader_name'
        , 'enable_global_age_restriction'
        , 'enable_quicklist'
        , 'hide_empty_collection'
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
        , 'enable_tmdb_mature_content'
        , 'tmdb_enable_on_front_end'
        , 'enable_comments_censor'
        , 'enable_video_description_censor'
        , 'enable_video_description_link'
        , 'enable_edit_photo_button'
        , 'enable_user_profil_censor'
        , 'enable_comments_video'
        , 'enable_comments_photo'
        , 'enable_comments_collection'
        , 'enable_comments_channel'
        , 'photo_rating'
        , 'own_photo_rating'
        , 'enable_storage_history'
        , 'enable_storage_history_fo'
        , 'enable_social_networks_links_footer'
        , 'enable_social_networks_links_home_sidebar'
        , 'enable_video_view_history'
        , 'home_enable_fullwidth'
        , 'home_disable_sidebar'
        , 'home_display_featured_collections'
        , 'home_display_recent_videos'
        , 'enable_access_view_video_history'
        , 'enable_visual_editor_comments'
        , 'display_featured_video'
        , 'enable_collection_internal_sharing'
        , 'enable_collection_link_sharing'
        , 'enable_country_video_field'
        , 'enable_location_video_field'
        , 'enable_recorded_date_video_field'
        , 'allow_tag_space'
        , 'enable_video_thumbs_preview'
        , 'enable_photo_categories'
        , 'enable_video_categories'
        , 'enable_collection_categories'
        , 'enable_theme_change'
        , 'enable_channel_slogan'
        , 'enable_channel_description'
        , 'enable_channels_slogan_display'
        , 'enable_user_self_deletion'
        , 'enable_cookie_banner'
        , 'enable_public_video_page'
        , 'can_upload_subtitles'
        , 'enable_anonymous_stats'
        , 'enable_video_embed_players'
        , 'videos_enable_fullwidth'
        , 'collections_enable_fullwidth'
        , 'collection_enable_fullwidth'
        , 'autoplay_video'
        , 'autoplay_embed'
        , 'contextual_menu_disabled'
        , 'control_bar_logo'
        , 'enable_360_video'
        , 'chromecast'
        , 'player_thumbnails'
        , 'enable_allow_alias_email'
        , 'enable_favorite_icon'
    ];

    $config_booleans_to_refactor = [
        'closed'
        , 'enable_update_checker'
        , 'allow_language_change'
        , 'allow_registeration'
        , 'pick_geo_country'
        , 'email_verification'
        , 'use_subs'
        , 'video_embed'
        , 'video_download'
        , 'bits_color_warning'
        , 'video_rating'
        , 'own_video_rating'
        , 'comment_rating'
        , 'collection_rating'
        , 'own_collection_rating'
        , 'channel_rating'
        , 'own_channel_rating'
        , 'photo_crop'
        , 'show_collapsed_checkboxes'
        , 'activation'
        , 'photo_activation'
        , 'player_subtitles'
    ];

    $rows = [
        'allow_language_change',
        'allow_unicode_usernames',
        'allow_username_spaces',
        'allow_registeration',
        'enable_advertisement',
        'anonym_comments',
        'enable_sub_collection',
        'enable_rss_feeds',

        'background_color',
        'background_upload',
        'background_url',
        'email_domain_restriction',

        'closed',
        'closed_msg',
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

        'email_verification',
        'show_collapsed_checkboxes',

        'gravatars',

        'keywords',

        'max_bg_width',
        'max_video_title',
        'max_video_desc',
        'max_username',
        'min_video_title',
        'min_video_desc',
        'min_age_reg',
        'min_username',
        'max_comment_chr',
        'enable_comments_censor',
        'enable_video_description_censor',
        'enable_video_description_link',
        'censored_words',
        'enable_user_profil_censor',
        'enable_comments_video',
        'enable_comments_photo',
        'enable_comments_collection',
        'enable_comments_channel',
        'enable_visual_editor_comments',

        'own_channel_rating',
        'own_collection_rating',
        'own_video_rating',
        'own_photo_rating',

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

        'site_title',
        'site_slogan',
        'seo',
        'seo_vido_url',
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
        'enable_hide_uploader_name',
        'enable_global_age_restriction',
        'enable_sitemap',

        'users_items_subscriptions',
        'users_items_contacts_channel',
        'users_items_search_page',

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
        'video_rating',
        'photo_rating',
        'video_categories',
        'feedsSection',
        'popup_video',
        'video_round_views',
        'enable_quicklist',

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
        'enable_edit_photo_button',
        'tmdb_enable_on_front_end',

        'hide_empty_collection',
        'playlistsSection',
        'enable_storage_history',
        'enable_storage_history_fo',
        'default_theme',
        'enable_social_networks_links_footer',
        'enable_social_networks_links_home_sidebar',
        'enable_video_view_history',
        'homepage_recent_videos_display',
        'homepage_recent_video_style',
        'homepage_recent_video_ratio',
        'list_recent_videos',
        'list_featured_videos',
        'home_enable_fullwidth',
        'home_disable_sidebar',
        'home_display_featured_collections',
        'homepage_collection_video_style',
        'homepage_collection_video_ratio',
        'list_home_collection_videos',
        'home_display_recent_videos',
        'enable_video_view_history',
        'enable_video_view_history',
        'enable_access_view_video_history',
        'video_list_view_video_history',
        'limit_photo_related',
        'display_featured_video',
        'featured_video_style',
        'enable_collection_internal_sharing',
        'enable_collection_link_sharing',
        'enable_country_video_field',
        'enable_location_video_field',
        'enable_recorded_date_video_field',
        'allow_tag_space',
        'max_profile_pic_width',
        'custom_css',
        'enable_video_thumbs_preview',
        'video_thumbs_preview_count',
        'enable_photo_categories',
        'enable_video_categories',
        'enable_collection_categories',
        'enable_theme_change',
        'autoplay_video',
        'embed_player_height',
        'embed_player_width',
        'autoplay_embed',
        'chromecast',
        'control_bar_logo',
        'contextual_menu_disabled',
        'enable_channel_slogan',
        'enable_channel_description',
        'enable_channels_slogan_display',
        'enable_user_self_deletion',
        'enable_cookie_banner',

        'player_logo_url',
        'player_thumbnails',
        'player_default_resolution',
        'player_default_resolution_hls',
        'player_subtitles',
        'enable_360_video',
        'activation',
        'photo_activation',

        'max_photo_categories',
        'max_collection_categories',
        'channel_video_style',
        'enable_public_video_page',
        'can_upload_subtitles',
        'videos_video_style',
        'enable_anonymous_stats',
        'enable_video_embed_players',
        'enable_anonymous_stats',
        'enable_multi_factor_authentification',
        'videos_enable_fullwidth',
        'collections_enable_fullwidth',
        'collection_enable_fullwidth',
        'enable_allow_alias_email',
        'enable_favorite_icon'
    ];

    //Numeric Array
    $num_array = [
        'channels_list_per_page',

        'max_video_title',
        'max_video_desc',
        'min_video_title',
        'min_video_desc',

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

        'photo_lar_width',
        'photo_thumb_width',
        'photo_thumb_height',
        'photo_med_width',
        'photo_med_height',

        'video_list_view_video_history',
        'limit_photo_related',

        'max_profile_pic_width',
        'list_featured_videos',
        'video_thumbs_preview_count',

        'max_photo_categories',
        'max_collection_categories'
    ];

    $has_missing_config = false;
    foreach ($rows as $field) {
        $value = ($_POST[$field]);
        if (in_array($field, $num_array)) {
            if ($field == 'min_age_reg' && ($value > 99 || $value <= 0 || !is_numeric($value) )) {
                e(lang('error_age_restriction_save'));
                continue;
            }
            if (($value <= 0 || !is_numeric($value)) && !in_array($field, ['video_categories', 'max_collection_categories', 'max_photo_categories']) ) {
                $value = 1;
            }
        }

        if ($field=='date_format' && !validatePHPDateFormat($value)) {
            e(lang('invalid_date_format'));
            continue;
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

        if (!isset(myquery::getInstance()->Get_Website_Details()[$field])) {
            if( !$has_missing_config ){
                e(lang('error_missing_config_please_use_tool', DirPath::getUrl('admin_area') . 'admin_tool.php?code_tool=install_missing_config'),'w',false);
                $has_missing_config = true;
            }
            if( System::isInDev() ){
                $tmp_text = 'Missing config: '.$field;
                error_log($tmp_text);
                DiscordLog::sendDump($tmp_text);
            }
            continue;
        }

        if( !is_null($value) ){
            myquery::getInstance()->Set_Website_Details($field, $value);
        } else {
            DiscordLog::sendDump('Missing value for config: '.$field);
        }
    }

    if (!empty($_FILES['upload_logo']['name'])) {
        // function used to upload site logo.
        upload_image('logo');
    }
    if (!empty($_FILES['upload_favicon']['name'])) {
        // function used to upload site logo.
        upload_image('favicon');
    }
    if( !empty($_FILES['upload_player-logo']['name']) ){
        upload_image('player-logo');
    }

    //clear cache
    CacheRedis::flushAll();
    unset($_SESSION['check_global_configs']);

    e('Website settings have been updated', 'm');

    //reset permissions check cache
    if (isset($_SESSION['folder_access'])) {
        unset($_SESSION['folder_access']);
    }
}

$row = myquery::getInstance()->Get_Website_Details();
Assign('row', $row);

subtitle(lang('basic_settings'));

$filepath_custom_css = DirPath::get('files') . 'custom.css';
assign('custom_css', $_POST['custom_css'] ?? file_get_contents($filepath_custom_css));

if (!empty($_POST)) {
    if( !empty($_POST['custom_css']) ){
        if (is_writable(DirPath::get('files'))) {
            file_put_contents($filepath_custom_css, $_POST['custom_css']);
        } else {
            e('"files" directory is not writeable');
        }
    } else {
        unlink($filepath_custom_css);
    }
}


$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'jquery-ui-1.13.2.min.js'             => 'global'
    ,'pages/main/main'.$min_suffixe.'.js' => 'admin'
]);
template_files('setting_basic.html');
display_it();
