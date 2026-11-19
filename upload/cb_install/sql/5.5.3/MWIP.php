<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}config` ADD COLUMN `description_key` varchar(191) DEFAULT NULL', [], [
            'table' => 'config',
            'column' => 'description_key'
        ]);

        // Stable configuration names; never overwrite administrator values.
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_activation\' WHERE `name` = \'activation\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allow_conversion_1_percent\' WHERE `name` = \'allow_conversion_1_percent\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allow_language_change\' WHERE `name` = \'allow_language_change\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allow_registeration\' WHERE `name` = \'allow_registeration\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allow_tag_space\' WHERE `name` = \'allow_tag_space\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allow_unicode_usernames\' WHERE `name` = \'allow_unicode_usernames\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allow_username_spaces\' WHERE `name` = \'allow_username_spaces\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allowed_photo_types\' WHERE `name` = \'allowed_photo_types\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_allowed_video_types\' WHERE `name` = \'allowed_video_types\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_anonym_comments\' WHERE `name` = \'anonym_comments\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_approve_video_notification\' WHERE `name` = \'approve_video_notification\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_audio_codec\' WHERE `name` = \'audio_codec\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_automate_launch_mode\' WHERE `name` = \'automate_launch_mode\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_autoplay_embed\' WHERE `name` = \'autoplay_embed\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_autoplay_video\' WHERE `name` = \'autoplay_video\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_background_color\' WHERE `name` = \'background_color\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_background_upload\' WHERE `name` = \'background_upload\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_background_url\' WHERE `name` = \'background_url\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_base_url\' WHERE `name` = \'base_url\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_bits_color_warning\' WHERE `name` = \'bits_color_warning\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_cache_auth\' WHERE `name` = \'cache_auth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_cache_enable\' WHERE `name` = \'cache_enable\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_cache_host\' WHERE `name` = \'cache_host\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_cache_password\' WHERE `name` = \'cache_password\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_cache_port\' WHERE `name` = \'cache_port\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_can_upload_subtitles\' WHERE `name` = \'can_upload_subtitles\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_censored_words\' WHERE `name` = \'censored_words\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_channel_rating\' WHERE `name` = \'channel_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_channel_video_style\' WHERE `name` = \'channel_video_style\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_channelssection\' WHERE `name` = \'channelsSection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_channels_list_per_page\' WHERE `name` = \'channels_list_per_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_chromecast\' WHERE `name` = \'chromecast\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_chromecast_fix\' WHERE `name` = \'chromecast_fix\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_chunk_upload_size\' WHERE `name` = \'chunk_upload_size\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_closed\' WHERE `name` = \'closed\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_closed_msg\' WHERE `name` = \'closed_msg\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_cloudflare_upload_limit\' WHERE `name` = \'cloudflare_upload_limit\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_collection_top_collections\' WHERE `name` = \'collection_collection_top_collections\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_enable_fullwidth\' WHERE `name` = \'collection_enable_fullwidth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_home_top_collections\' WHERE `name` = \'collection_home_top_collections\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_items_page\' WHERE `name` = \'collection_items_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_per_page\' WHERE `name` = \'collection_per_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_photos_top_collections\' WHERE `name` = \'collection_photos_top_collections\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_rating\' WHERE `name` = \'collection_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collection_search_result\' WHERE `name` = \'collection_search_result\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collectionssection\' WHERE `name` = \'collectionsSection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_collections_enable_fullwidth\' WHERE `name` = \'collections_enable_fullwidth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_comment_rating\' WHERE `name` = \'comment_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_comments_captcha\' WHERE `name` = \'comments_captcha\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_comments_per_page\' WHERE `name` = \'comments_per_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_contextual_menu_disabled\' WHERE `name` = \'contextual_menu_disabled\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_control_bar_logo\' WHERE `name` = \'control_bar_logo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_conversion_type\' WHERE `name` = \'conversion_type\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_custom_css\' WHERE `name` = \'custom_css\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_date_format\' WHERE `name` = \'date_format\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_default_country_iso2\' WHERE `name` = \'default_country_iso2\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_default_theme\' WHERE `name` = \'default_theme\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_delete_collection_on_delete_user\' WHERE `name` = \'delete_collection_on_delete_user\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_delete_comments_on_delete_user\' WHERE `name` = \'delete_comments_on_delete_user\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_delete_mass_upload\' WHERE `name` = \'delete_mass_upload\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_delete_photo_on_delete_user\' WHERE `name` = \'delete_photo_on_delete_user\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_delete_playlist_on_delete_user\' WHERE `name` = \'delete_playlist_on_delete_user\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_delete_video_on_delete_user\' WHERE `name` = \'delete_video_on_delete_user\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_description\' WHERE `name` = \'description\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_disable_email\' WHERE `name` = \'disable_email\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_disallowed_usernames\' WHERE `name` = \'disallowed_usernames\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_display_featured_video\' WHERE `name` = \'display_featured_video\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_display_language_flag\' WHERE `name` = \'display_language_flag\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_email_domain_restriction\' WHERE `name` = \'email_domain_restriction\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_email_sender_address\' WHERE `name` = \'email_sender_address\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_email_sender_name\' WHERE `name` = \'email_sender_name\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_email_verification\' WHERE `name` = \'email_verification\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_embed_player_height\' WHERE `name` = \'embed_player_height\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_embed_player_width\' WHERE `name` = \'embed_player_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_360_video\' WHERE `name` = \'enable_360_video\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_access_view_video_history\' WHERE `name` = \'enable_access_view_video_history\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_advertisement\' WHERE `name` = \'enable_advertisement\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_age_restriction\' WHERE `name` = \'enable_age_restriction\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_all_categ_for_channel\' WHERE `name` = \'enable_all_categ_for_channel\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_all_categ_for_collection\' WHERE `name` = \'enable_all_categ_for_collection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_all_categ_for_photo\' WHERE `name` = \'enable_all_categ_for_photo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_all_categ_for_video\' WHERE `name` = \'enable_all_categ_for_video\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_allow_alias_email\' WHERE `name` = \'enable_allow_alias_email\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_anonymous_stats\' WHERE `name` = \'enable_anonymous_stats\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_blur_restricted_content\' WHERE `name` = \'enable_blur_restricted_content\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_channel_categories_as_submenu\' WHERE `name` = \'enable_channel_categories_as_submenu\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_channel_description\' WHERE `name` = \'enable_channel_description\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_channel_slogan\' WHERE `name` = \'enable_channel_slogan\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_channels_slogan_display\' WHERE `name` = \'enable_channels_slogan_display\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_chunk_upload\' WHERE `name` = \'enable_chunk_upload\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_collection_backdrop\' WHERE `name` = \'enable_collection_backdrop\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_collection_categories\' WHERE `name` = \'enable_collection_categories\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_collection_categories_as_submenu\' WHERE `name` = \'enable_collection_categories_as_submenu\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_collection_internal_sharing\' WHERE `name` = \'enable_collection_internal_sharing\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_collection_link_sharing\' WHERE `name` = \'enable_collection_link_sharing\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_collection_poster\' WHERE `name` = \'enable_collection_poster\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_comments_censor\' WHERE `name` = \'enable_comments_censor\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_comments_channel\' WHERE `name` = \'enable_comments_channel\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_comments_collection\' WHERE `name` = \'enable_comments_collection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_comments_photo\' WHERE `name` = \'enable_comments_photo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_comments_video\' WHERE `name` = \'enable_comments_video\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_cookie_banner\' WHERE `name` = \'enable_cookie_banner\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_country\' WHERE `name` = \'enable_country\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_country_video_field\' WHERE `name` = \'enable_country_video_field\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_edit_button\' WHERE `name` = \'enable_edit_button\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_edit_photo_button\' WHERE `name` = \'enable_edit_photo_button\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_external_rate_field\' WHERE `name` = \'enable_external_rate_field\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_external_rate_from_tmdb\' WHERE `name` = \'enable_external_rate_from_tmdb\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_external_rate_ratings_on_fo\' WHERE `name` = \'enable_external_rate_ratings_on_fo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_external_ratings_field\' WHERE `name` = \'enable_external_ratings_field\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_external_ratings_from_tmdb\' WHERE `name` = \'enable_external_ratings_from_tmdb\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_favorite_icon\' WHERE `name` = \'enable_favorite_icon\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_favorite_icon_collection\' WHERE `name` = \'enable_favorite_icon_collection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_favorite_icon_photo\' WHERE `name` = \'enable_favorite_icon_photo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_featured_collection_hierarchy\' WHERE `name` = \'enable_featured_collection_hierarchy\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_gender\' WHERE `name` = \'enable_gender\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_global_age_restriction\' WHERE `name` = \'enable_global_age_restriction\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_hide_uploader_name\' WHERE `name` = \'enable_hide_uploader_name\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_location_video_field\' WHERE `name` = \'enable_location_video_field\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_multi_factor_authentification\' WHERE `name` = \'enable_multi_factor_authentification\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_photo_categories\' WHERE `name` = \'enable_photo_categories\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_photo_categories_as_submenu\' WHERE `name` = \'enable_photo_categories_as_submenu\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_photo_file_upload\' WHERE `name` = \'enable_photo_file_upload\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_public_video_page\' WHERE `name` = \'enable_public_video_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_quicklist\' WHERE `name` = \'enable_quicklist\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_recorded_date_video_field\' WHERE `name` = \'enable_recorded_date_video_field\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_rss_feeds\' WHERE `name` = \'enable_rss_feeds\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_sitemap\' WHERE `name` = \'enable_sitemap\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_social_networks_links_footer\' WHERE `name` = \'enable_social_networks_links_footer\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_social_networks_links_home_sidebar\' WHERE `name` = \'enable_social_networks_links_home_sidebar\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_storage_history\' WHERE `name` = \'enable_storage_history\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_storage_history_fo\' WHERE `name` = \'enable_storage_history_fo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_sub_collection\' WHERE `name` = \'enable_sub_collection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_theme_change\' WHERE `name` = \'enable_theme_change\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_tmdb\' WHERE `name` = \'enable_tmdb\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_tmdb_mature_content\' WHERE `name` = \'enable_tmdb_mature_content\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_update_checker\' WHERE `name` = \'enable_update_checker\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_about\' WHERE `name` = \'enable_user_about\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_category\' WHERE `name` = \'enable_user_category\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_city\' WHERE `name` = \'enable_user_city\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_compagnies\' WHERE `name` = \'enable_user_compagnies\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_dob_edition\' WHERE `name` = \'enable_user_dob_edition\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_education\' WHERE `name` = \'enable_user_education\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_favorite_books\' WHERE `name` = \'enable_user_favorite_books\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_favorite_movies\' WHERE `name` = \'enable_user_favorite_movies\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_favorite_music\' WHERE `name` = \'enable_user_favorite_music\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_firstname_lastname\' WHERE `name` = \'enable_user_firstname_lastname\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_hobbies\' WHERE `name` = \'enable_user_hobbies\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_hometown\' WHERE `name` = \'enable_user_hometown\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_occupation\' WHERE `name` = \'enable_user_occupation\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_postcode\' WHERE `name` = \'enable_user_postcode\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_profil_censor\' WHERE `name` = \'enable_user_profil_censor\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_relation_status\' WHERE `name` = \'enable_user_relation_status\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_schools\' WHERE `name` = \'enable_user_schools\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_self_deletion\' WHERE `name` = \'enable_user_self_deletion\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_status\' WHERE `name` = \'enable_user_status\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_user_website\' WHERE `name` = \'enable_user_website\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_actor\' WHERE `name` = \'enable_video_actor\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_backdrop\' WHERE `name` = \'enable_video_backdrop\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_categories\' WHERE `name` = \'enable_video_categories\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_categories_as_submenu\' WHERE `name` = \'enable_video_categories_as_submenu\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_crew\' WHERE `name` = \'enable_video_crew\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_description_censor\' WHERE `name` = \'enable_video_description_censor\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_description_link\' WHERE `name` = \'enable_video_description_link\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_director\' WHERE `name` = \'enable_video_director\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_embed_players\' WHERE `name` = \'enable_video_embed_players\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_executive_producer\' WHERE `name` = \'enable_video_executive_producer\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_file_upload\' WHERE `name` = \'enable_video_file_upload\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_genre\' WHERE `name` = \'enable_video_genre\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_internal_sharing\' WHERE `name` = \'enable_video_internal_sharing\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_link_sharing\' WHERE `name` = \'enable_video_link_sharing\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_poster\' WHERE `name` = \'enable_video_poster\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_producer\' WHERE `name` = \'enable_video_producer\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_remote_play\' WHERE `name` = \'enable_video_remote_play\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_social_sharing\' WHERE `name` = \'enable_video_social_sharing\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_thumbs_preview\' WHERE `name` = \'enable_video_thumbs_preview\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_video_view_history\' WHERE `name` = \'enable_video_view_history\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_enable_visual_editor_comments\' WHERE `name` = \'enable_visual_editor_comments\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_extract_subtitles\' WHERE `name` = \'extract_subtitles\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_favicon_name\' WHERE `name` = \'favicon_name\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_featured_video_style\' WHERE `name` = \'featured_video_style\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_feedssection\' WHERE `name` = \'feedsSection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_ffmpegpath\' WHERE `name` = \'ffmpegpath\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_ffprobe_path\' WHERE `name` = \'ffprobe_path\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_force_8bits\' WHERE `name` = \'force_8bits\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_git_path\' WHERE `name` = \'git_path\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_gravatars\' WHERE `name` = \'gravatars\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_hide_empty_collection\' WHERE `name` = \'hide_empty_collection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_home_disable_sidebar\' WHERE `name` = \'home_disable_sidebar\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_home_display_featured_collections\' WHERE `name` = \'home_display_featured_collections\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_home_display_recent_videos\' WHERE `name` = \'home_display_recent_videos\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_home_enable_fullwidth\' WHERE `name` = \'home_enable_fullwidth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_homepage_collection_video_ratio\' WHERE `name` = \'homepage_collection_video_ratio\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_homepage_collection_video_style\' WHERE `name` = \'homepage_collection_video_style\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_homepage_recent_video_ratio\' WHERE `name` = \'homepage_recent_video_ratio\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_homepage_recent_video_style\' WHERE `name` = \'homepage_recent_video_style\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_homepage_recent_videos_display\' WHERE `name` = \'homepage_recent_videos_display\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_keep_audio_tracks\' WHERE `name` = \'keep_audio_tracks\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_keep_ratio_photo\' WHERE `name` = \'keep_ratio_photo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_keep_subtitles\' WHERE `name` = \'keep_subtitles\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_keywords\' WHERE `name` = \'keywords\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_limit_photo_related\' WHERE `name` = \'limit_photo_related\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_list_featured_videos\' WHERE `name` = \'list_featured_videos\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_list_home_collection_videos\' WHERE `name` = \'list_home_collection_videos\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_list_recent_videos\' WHERE `name` = \'list_recent_videos\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_logo_name\' WHERE `name` = \'logo_name\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_mail_type\' WHERE `name` = \'mail_type\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_main_menu_order\' WHERE `name` = \'main_menu_order\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_bg_width\' WHERE `name` = \'max_bg_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_collection_categories\' WHERE `name` = \'max_collection_categories\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_comment_chr\' WHERE `name` = \'max_comment_chr\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_conversion\' WHERE `name` = \'max_conversion\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_photo_categories\' WHERE `name` = \'max_photo_categories\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_photo_size\' WHERE `name` = \'max_photo_size\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_profile_pic_width\' WHERE `name` = \'max_profile_pic_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_upload_size\' WHERE `name` = \'max_upload_size\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_username\' WHERE `name` = \'max_username\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_video_desc\' WHERE `name` = \'max_video_desc\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_video_duration\' WHERE `name` = \'max_video_duration\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_max_video_title\' WHERE `name` = \'max_video_title\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_maximum_allowed_subtitle_size\' WHERE `name` = \'maximum_allowed_subtitle_size\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_media_info\' WHERE `name` = \'media_info\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_min_age_reg\' WHERE `name` = \'min_age_reg\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_min_username\' WHERE `name` = \'min_username\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_min_video_desc\' WHERE `name` = \'min_video_desc\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_min_video_title\' WHERE `name` = \'min_video_title\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_nginx_path\' WHERE `name` = \'nginx_path\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_num_thumbs\' WHERE `name` = \'num_thumbs\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_only_keep_max_resolution\' WHERE `name` = \'only_keep_max_resolution\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_own_channel_rating\' WHERE `name` = \'own_channel_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_own_collection_rating\' WHERE `name` = \'own_collection_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_own_comment_rating\' WHERE `name` = \'own_comment_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_own_photo_rating\' WHERE `name` = \'own_photo_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_own_video_rating\' WHERE `name` = \'own_video_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_activation\' WHERE `name` = \'photo_activation\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_channel_page\' WHERE `name` = \'photo_channel_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_crop\' WHERE `name` = \'photo_crop\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_enable_nsfw_check\' WHERE `name` = \'photo_enable_nsfw_check\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_home_tabs\' WHERE `name` = \'photo_home_tabs\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_lar_width\' WHERE `name` = \'photo_lar_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_main_list\' WHERE `name` = \'photo_main_list\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_med_height\' WHERE `name` = \'photo_med_height\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_med_width\' WHERE `name` = \'photo_med_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_nsfw_check_model\' WHERE `name` = \'photo_nsfw_check_model\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_other_limit\' WHERE `name` = \'photo_other_limit\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_rating\' WHERE `name` = \'photo_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_ratio\' WHERE `name` = \'photo_ratio\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_search_result\' WHERE `name` = \'photo_search_result\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_thumb_height\' WHERE `name` = \'photo_thumb_height\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_thumb_width\' WHERE `name` = \'photo_thumb_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_thumbs_format\' WHERE `name` = \'photo_thumbs_format\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_user_favorites\' WHERE `name` = \'photo_user_favorites\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photo_user_photos\' WHERE `name` = \'photo_user_photos\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photossection\' WHERE `name` = \'photosSection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_photos_enable_fullwidth\' WHERE `name` = \'photos_enable_fullwidth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_php_path\' WHERE `name` = \'php_path\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_pick_geo_country\' WHERE `name` = \'pick_geo_country\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_picture_upload\' WHERE `name` = \'picture_upload\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_picture_url\' WHERE `name` = \'picture_url\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_player-logo_name\' WHERE `name` = \'player-logo_name\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_player_default_resolution\' WHERE `name` = \'player_default_resolution\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_player_default_resolution_hls\' WHERE `name` = \'player_default_resolution_hls\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_player_logo_url\' WHERE `name` = \'player_logo_url\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_player_subtitles\' WHERE `name` = \'player_subtitles\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_player_thumbnails\' WHERE `name` = \'player_thumbnails\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_playlistssection\' WHERE `name` = \'playlistsSection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_popup_video\' WHERE `name` = \'popup_video\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_proxy_auth\' WHERE `name` = \'proxy_auth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_proxy_enable\' WHERE `name` = \'proxy_enable\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_proxy_password\' WHERE `name` = \'proxy_password\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_proxy_port\' WHERE `name` = \'proxy_port\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_proxy_url\' WHERE `name` = \'proxy_url\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_proxy_username\' WHERE `name` = \'proxy_username\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_random_photo_order\' WHERE `name` = \'random_photo_order\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_random_video_order\' WHERE `name` = \'random_video_order\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_ratio_photo\' WHERE `name` = \'ratio_photo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_sbrate\' WHERE `name` = \'sbrate\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_send_comment_notification\' WHERE `name` = \'send_comment_notification\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_seo\' WHERE `name` = \'seo\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_seo_vido_url\' WHERE `name` = \'seo_vido_url\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_show_collapsed_checkboxes\' WHERE `name` = \'show_collapsed_checkboxes\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_site_slogan\' WHERE `name` = \'site_slogan\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_site_title\' WHERE `name` = \'site_title\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_smtp_auth\' WHERE `name` = \'smtp_auth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_smtp_host\' WHERE `name` = \'smtp_host\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_smtp_pass\' WHERE `name` = \'smtp_pass\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_smtp_port\' WHERE `name` = \'smtp_port\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_smtp_user\' WHERE `name` = \'smtp_user\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_srate\' WHERE `name` = \'srate\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_stay_mp4\' WHERE `name` = \'stay_mp4\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_store_guest_session\' WHERE `name` = \'store_guest_session\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_subtitle_format\' WHERE `name` = \'subtitle_format\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_thumb_background_color\' WHERE `name` = \'thumb_background_color\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_timezone\' WHERE `name` = \'timezone\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_enable_on_front_end\' WHERE `name` = \'tmdb_enable_on_front_end\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_actors\' WHERE `name` = \'tmdb_get_actors\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_age_restriction\' WHERE `name` = \'tmdb_get_age_restriction\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_backdrop\' WHERE `name` = \'tmdb_get_backdrop\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_crew\' WHERE `name` = \'tmdb_get_crew\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_description\' WHERE `name` = \'tmdb_get_description\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_director\' WHERE `name` = \'tmdb_get_director\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_executive_producer\' WHERE `name` = \'tmdb_get_executive_producer\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_genre\' WHERE `name` = \'tmdb_get_genre\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_poster\' WHERE `name` = \'tmdb_get_poster\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_producer\' WHERE `name` = \'tmdb_get_producer\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_release_date\' WHERE `name` = \'tmdb_get_release_date\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_get_title\' WHERE `name` = \'tmdb_get_title\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_mature_content_age\' WHERE `name` = \'tmdb_mature_content_age\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_search\' WHERE `name` = \'tmdb_search\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_tmdb_token\' WHERE `name` = \'tmdb_token\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_use_backdrop_as_default_thumb\' WHERE `name` = \'use_backdrop_as_default_thumb\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_use_subs\' WHERE `name` = \'use_subs\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_users_items_contacts_channel\' WHERE `name` = \'users_items_contacts_channel\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_users_items_search_page\' WHERE `name` = \'users_items_search_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_users_items_subscriptions\' WHERE `name` = \'users_items_subscriptions\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_vid_cat_height\' WHERE `name` = \'vid_cat_height\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_vid_cat_width\' WHERE `name` = \'vid_cat_width\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_categories\' WHERE `name` = \'video_categories\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_codec\' WHERE `name` = \'video_codec\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_download\' WHERE `name` = \'video_download\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_embed\' WHERE `name` = \'video_embed\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_enable_fullwidth\' WHERE `name` = \'video_enable_fullwidth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_enable_nsfw_check\' WHERE `name` = \'video_enable_nsfw_check\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_list_view_video_history\' WHERE `name` = \'video_list_view_video_history\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_nsfw_check_model\' WHERE `name` = \'video_nsfw_check_model\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_rating\' WHERE `name` = \'video_rating\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_remove_black_bars\' WHERE `name` = \'video_remove_black_bars\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_round_views\' WHERE `name` = \'video_round_views\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_thumbs_format\' WHERE `name` = \'video_thumbs_format\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_video_thumbs_preview_count\' WHERE `name` = \'video_thumbs_preview_count\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videossection\' WHERE `name` = \'videosSection\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_enable_fullwidth\' WHERE `name` = \'videos_enable_fullwidth\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_item_channel_page\' WHERE `name` = \'videos_item_channel_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_items_hme_page\' WHERE `name` = \'videos_items_hme_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_items_search_page\' WHERE `name` = \'videos_items_search_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_items_ufav_page\' WHERE `name` = \'videos_items_ufav_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_items_uvid_page\' WHERE `name` = \'videos_items_uvid_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_list_per_page\' WHERE `name` = \'videos_list_per_page\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_videos_video_style\' WHERE `name` = \'videos_video_style\';');
        self::query('UPDATE `{tbl_prefix}config` SET `description_key` = \'settings_description_vrate\' WHERE `name` = \'vrate\';');

        self::generateTranslation('settings_description_activation', [
            'fr' => 'Exige l\'approbation d\'une vidéo avant sa publication.',
            'en' => 'Requires video approval before publication.'
        ]);
        self::generateTranslation('settings_description_allow_conversion_1_percent', [
            'fr' => 'Tolère une dimension source inférieure de un pour cent à la résolution cible.',
            'en' => 'Allows source dimensions one percent below the target resolution.'
        ]);
        self::generateTranslation('settings_description_allow_language_change', [
            'fr' => 'Permet aux visiteurs de choisir la langue du site.',
            'en' => 'Allows visitors to choose the website language.'
        ]);
        self::generateTranslation('settings_description_allow_registeration', [
            'fr' => 'Permet aux visiteurs de créer un compte.',
            'en' => 'Allows visitors to create an account.'
        ]);
        self::generateTranslation('settings_description_allow_tag_space', [
            'fr' => 'Autorise les espaces à l\'intérieur des tags.',
            'en' => 'Allows spaces inside tags.'
        ]);
        self::generateTranslation('settings_description_allow_unicode_usernames', [
            'fr' => 'Autorise les caractères Unicode dans les identifiants utilisateur.',
            'en' => 'Allows Unicode characters in usernames.'
        ]);
        self::generateTranslation('settings_description_allow_username_spaces', [
            'fr' => 'Autorise les espaces dans les identifiants utilisateur.',
            'en' => 'Allows spaces in usernames.'
        ]);
        self::generateTranslation('settings_description_allowed_photo_types', [
            'fr' => 'Définit les extensions de fichiers photo acceptées, séparées par des virgules.',
            'en' => 'Sets accepted comma-separated photo file extensions.'
        ]);
        self::generateTranslation('settings_description_allowed_video_types', [
            'fr' => 'Définit les extensions de fichiers vidéo acceptées, séparées par des virgules.',
            'en' => 'Sets accepted comma-separated video file extensions.'
        ]);
        self::generateTranslation('settings_description_anonym_comments', [
            'fr' => 'Permet aux visiteurs non connectés de publier des commentaires.',
            'en' => 'Allows signed-out visitors to post comments.'
        ]);
        self::generateTranslation('settings_description_approve_video_notification', [
            'fr' => 'Envoie un email lorsque la vidéo est approuvée.',
            'en' => 'Sends an email when a video is approved.'
        ]);
        self::generateTranslation('settings_description_audio_codec', [
            'fr' => 'Choisit l\'encodeur audio utilisé par FFmpeg.',
            'en' => 'Chooses the audio encoder used by FFmpeg.'
        ]);
        self::generateTranslation('settings_description_automate_launch_mode', [
            'fr' => 'Choisit le déclenchement des tâches automatiques par cron, par activité utilisateur ou leur désactivation.',
            'en' => 'Chooses automatic task triggering through cron, user activity or disables it.'
        ]);
        self::generateTranslation('settings_description_autoplay_embed', [
            'fr' => 'Demande le démarrage automatique des vidéos intégrées.',
            'en' => 'Requests automatic playback of embedded videos.'
        ]);
        self::generateTranslation('settings_description_autoplay_video', [
            'fr' => 'Demande le démarrage automatique de la lecture vidéo.',
            'en' => 'Requests automatic video playback.'
        ]);
        self::generateTranslation('settings_description_background_color', [
            'fr' => 'Permet de choisir la couleur de fond du profil.',
            'en' => 'Allows choosing the profile background color.'
        ]);
        self::generateTranslation('settings_description_background_upload', [
            'fr' => 'Permet d\'envoyer une image de fond pour le profil.',
            'en' => 'Allows uploading a profile background image.'
        ]);
        self::generateTranslation('settings_description_background_url', [
            'fr' => 'Permet de choisir l\'image de fond du profil par son adresse.',
            'en' => 'Allows choosing a profile background image by its address.'
        ]);
        self::generateTranslation('settings_description_base_url', [
            'fr' => 'Définit l\'adresse publique de référence du site utilisée notamment dans les emails.',
            'en' => 'Sets the canonical public website address used in emails.'
        ]);
        self::generateTranslation('settings_description_bits_color_warning', [
            'fr' => 'Avertit des problèmes de compatibilité lorsque la profondeur des couleurs dépasse huit bits.',
            'en' => 'Warns about compatibility when video color depth exceeds eight bits.'
        ]);
        self::generateTranslation('settings_description_cache_auth', [
            'fr' => 'Active l\'authentification auprès du serveur Redis.',
            'en' => 'Enables authentication with the Redis server.'
        ]);
        self::generateTranslation('settings_description_cache_enable', [
            'fr' => 'Active le cache Redis pour limiter les calculs et accès aux données répétés.',
            'en' => 'Enables Redis caching to reduce repeated computation and data access.'
        ]);
        self::generateTranslation('settings_description_cache_host', [
            'fr' => 'Définit l\'adresse du serveur de cache Redis.',
            'en' => 'Sets the Redis cache server address.'
        ]);
        self::generateTranslation('settings_description_cache_password', [
            'fr' => 'Définit le mot de passe de connexion au cache Redis.',
            'en' => 'Sets the Redis cache login password.'
        ]);
        self::generateTranslation('settings_description_cache_port', [
            'fr' => 'Définit le port réseau du serveur Redis.',
            'en' => 'Sets the Redis server network port.'
        ]);
        self::generateTranslation('settings_description_can_upload_subtitles', [
            'fr' => 'Permet d\'ajouter des fichiers de sous-titres aux vidéos.',
            'en' => 'Allows adding subtitle files to videos.'
        ]);
        self::generateTranslation('settings_description_censored_words', [
            'fr' => 'Liste les mots séparés par des virgules à masquer lorsque la censure est activée.',
            'en' => 'Lists comma-separated words to hide when censorship is enabled.'
        ]);
        self::generateTranslation('settings_description_channel_rating', [
            'fr' => 'Autorise la notation des chaînes.',
            'en' => 'Allows rating channels.'
        ]);
        self::generateTranslation('settings_description_channel_video_style', [
            'fr' => 'Choisit la présentation des vignettes pour les vidéos des chaînes.',
            'en' => 'Chooses the card layout for channel videos.'
        ]);
        self::generateTranslation('settings_description_channelssection', [
            'fr' => 'Active la section des chaînes sur le site.',
            'en' => 'Enables the channels section on the website.'
        ]);
        self::generateTranslation('settings_description_channels_list_per_page', [
            'fr' => 'Limite le nombre de chaînes par page.',
            'en' => 'Limits the number of channels per page.'
        ]);
        self::generateTranslation('settings_description_chromecast', [
            'fr' => 'Active la diffusion des vidéos vers un appareil Chromecast.',
            'en' => 'Enables casting videos to a Chromecast device.'
        ]);
        self::generateTranslation('settings_description_chromecast_fix', [
            'fr' => 'Convertit l\'audio en stéréo pour améliorer la compatibilité Chromecast.',
            'en' => 'Converts audio to stereo to improve Chromecast compatibility.'
        ]);
        self::generateTranslation('settings_description_chunk_upload_size', [
            'fr' => 'Définit la taille des morceaux d\'envoi de fichiers, en Mo.',
            'en' => 'Sets file upload chunk size in MB.'
        ]);
        self::generateTranslation('settings_description_closed', [
            'fr' => 'Ferme le site aux visiteurs pendant la maintenance.',
            'en' => 'Closes the website to visitors during maintenance.'
        ]);
        self::generateTranslation('settings_description_closed_msg', [
            'fr' => 'Définit le message présenté lorsque le site est fermé.',
            'en' => 'Sets the message shown while the website is closed.'
        ]);
        self::generateTranslation('settings_description_cloudflare_upload_limit', [
            'fr' => 'Déclare la limite de taille des requêtes Cloudflare en Mo pour le diagnostic des envois.',
            'en' => 'Declares the Cloudflare request size limit in MB for upload diagnostics.'
        ]);
        self::generateTranslation('settings_description_collection_collection_top_collections', [
            'fr' => 'Enregistre le paramètre « collections mises en avant sur la page collection » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the featured collections on a collection page setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_collection_enable_fullwidth', [
            'fr' => 'Étend une collection sur toute la largeur disponible.',
            'en' => 'Expands a collection to the full available width.'
        ]);
        self::generateTranslation('settings_description_collection_home_top_collections', [
            'fr' => 'Limite le nombre de collections mises en avant sur l’accueil et la liste des collections.',
            'en' => 'Limits the number of featured collections on the homepage and collection listing.'
        ]);
        self::generateTranslation('settings_description_collection_items_page', [
            'fr' => 'Limite le nombre de éléments par page dans une collection.',
            'en' => 'Limits the number of items per collection page.'
        ]);
        self::generateTranslation('settings_description_collection_per_page', [
            'fr' => 'Limite le nombre de collections par page.',
            'en' => 'Limits the number of collections per page.'
        ]);
        self::generateTranslation('settings_description_collection_photos_top_collections', [
            'fr' => 'Limite le nombre de collections mises en avant sur la page des photos.',
            'en' => 'Limits the number of featured collections on the photo page.'
        ]);
        self::generateTranslation('settings_description_collection_rating', [
            'fr' => 'Autorise la notation des collections.',
            'en' => 'Allows rating collections.'
        ]);
        self::generateTranslation('settings_description_collection_search_result', [
            'fr' => 'Limite le nombre de collections par page de recherche.',
            'en' => 'Limits the number of collections per search page.'
        ]);
        self::generateTranslation('settings_description_collectionssection', [
            'fr' => 'Active la section des collections sur le site.',
            'en' => 'Enables the collections section on the website.'
        ]);
        self::generateTranslation('settings_description_collections_enable_fullwidth', [
            'fr' => 'Étend la liste des collections sur toute la largeur disponible.',
            'en' => 'Expands the collection listing to the full available width.'
        ]);
        self::generateTranslation('settings_description_comment_rating', [
            'fr' => 'Autorise la notation des commentaires.',
            'en' => 'Allows rating comments.'
        ]);
        self::generateTranslation('settings_description_comments_captcha', [
            'fr' => 'Choisit les utilisateurs devant résoudre un captcha pour commenter.',
            'en' => 'Chooses which users must solve a captcha to comment.'
        ]);
        self::generateTranslation('settings_description_comments_per_page', [
            'fr' => 'Enregistre le paramètre « commentaires par page » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the comments per page setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_contextual_menu_disabled', [
            'fr' => 'Désactive le menu du clic droit sur la vidéo.',
            'en' => 'Disables the video right-click menu.'
        ]);
        self::generateTranslation('settings_description_control_bar_logo', [
            'fr' => 'Affiche un logo dans la barre de commandes du lecteur.',
            'en' => 'Displays a logo in the player control bar.'
        ]);
        self::generateTranslation('settings_description_conversion_type', [
            'fr' => 'Choisit une sortie MP4 ou une diffusion HLS pour les vidéos converties.',
            'en' => 'Chooses MP4 output or HLS streaming for converted videos.'
        ]);
        self::generateTranslation('settings_description_custom_css', [
            'fr' => 'Applique une feuille de style personnalisée enregistrée dans le fichier custom.css.',
            'en' => 'Applies custom styling saved in the custom.css file.'
        ]);
        self::generateTranslation('settings_description_date_format', [
            'fr' => 'Définit le format PHP utilisé pour afficher les dates.',
            'en' => 'Sets the PHP format used to display dates.'
        ]);
        self::generateTranslation('settings_description_default_country_iso2', [
            'fr' => 'Présélectionne le pays du profil utilisateur.',
            'en' => 'Preselects the country in user profiles.'
        ]);
        self::generateTranslation('settings_description_default_theme', [
            'fr' => 'Choisit le thème visuel clair ou sombre utilisé par défaut.',
            'en' => 'Chooses the default light or dark visual theme.'
        ]);
        self::generateTranslation('settings_description_delete_collection_on_delete_user', [
            'fr' => 'Supprime les collections du compte lors de sa suppression.',
            'en' => 'Deletes account collections when the account is deleted.'
        ]);
        self::generateTranslation('settings_description_delete_comments_on_delete_user', [
            'fr' => 'Supprime les commentaires du compte lors de sa suppression.',
            'en' => 'Deletes account comments when the account is deleted.'
        ]);
        self::generateTranslation('settings_description_delete_mass_upload', [
            'fr' => 'Supprime les fichiers sources après leur import par l\'envoi en masse.',
            'en' => 'Deletes source files after importing them through mass upload.'
        ]);
        self::generateTranslation('settings_description_delete_photo_on_delete_user', [
            'fr' => 'Supprime les photos du compte lors de sa suppression.',
            'en' => 'Deletes account photos when the account is deleted.'
        ]);
        self::generateTranslation('settings_description_delete_playlist_on_delete_user', [
            'fr' => 'Supprime les listes de lecture du compte lors de sa suppression.',
            'en' => 'Deletes account playlists when the account is deleted.'
        ]);
        self::generateTranslation('settings_description_delete_video_on_delete_user', [
            'fr' => 'Supprime les vidéos du compte lors de sa suppression.',
            'en' => 'Deletes account videos when the account is deleted.'
        ]);
        self::generateTranslation('settings_description_description', [
            'fr' => 'Définit la description générale du site, notamment dans les flux RSS.',
            'en' => 'Sets the general website description, including RSS feeds.'
        ]);
        self::generateTranslation('settings_description_disable_email', [
            'fr' => 'Désactive l\'envoi des emails du site.',
            'en' => 'Disables website email delivery.'
        ]);
        self::generateTranslation('settings_description_disallowed_usernames', [
            'fr' => 'Définit les noms interdits lors du choix d\'un identifiant utilisateur.',
            'en' => 'Defines prohibited names when choosing a username.'
        ]);
        self::generateTranslation('settings_description_discord_error_log', [
            'fr' => 'Active l\'envoi des journaux d\'erreur vers Discord.',
            'en' => 'Enables sending error logs to Discord.'
        ]);
        self::generateTranslation('settings_description_discord_webhook_url', [
            'fr' => 'Définit l\'adresse du webhook Discord destinataire des journaux.',
            'en' => 'Sets the Discord webhook address receiving logs.'
        ]);
        self::generateTranslation('settings_description_display_featured_video', [
            'fr' => 'Affiche les vidéos mises en avant sur la page d\'accueil.',
            'en' => 'Displays featured videos on the homepage.'
        ]);
        self::generateTranslation('settings_description_display_language_flag', [
            'fr' => 'Affiche le drapeau à côté du nom des langues.',
            'en' => 'Displays a flag next to language names.'
        ]);
        self::generateTranslation('settings_description_email_domain_restriction', [
            'fr' => 'Limite les inscriptions aux domaines email autorisés, séparés par des virgules.',
            'en' => 'Restricts registration to authorized comma-separated email domains.'
        ]);
        self::generateTranslation('settings_description_email_sender_address', [
            'fr' => 'Définit l\'adresse de l\'expéditeur des emails du site.',
            'en' => 'Sets the sender address for website emails.'
        ]);
        self::generateTranslation('settings_description_email_sender_name', [
            'fr' => 'Définit le nom de l\'expéditeur des emails du site.',
            'en' => 'Sets the sender name for website emails.'
        ]);
        self::generateTranslation('settings_description_email_verification', [
            'fr' => 'Demande la validation de l\'adresse email lors de l\'inscription.',
            'en' => 'Requires email address verification during registration.'
        ]);
        self::generateTranslation('settings_description_embed_player_height', [
            'fr' => 'Définit la hauteur par défaut du lecteur intégré, en pixels.',
            'en' => 'Sets the default embedded player height in pixels.'
        ]);
        self::generateTranslation('settings_description_embed_player_width', [
            'fr' => 'Définit la largeur par défaut du lecteur intégré, en pixels.',
            'en' => 'Sets the default embedded player width in pixels.'
        ]);
        self::generateTranslation('settings_description_enable_360_video', [
            'fr' => 'Active la lecture des vidéos panoramiques à 360 degrés.',
            'en' => 'Enables playback of panoramic 360-degree videos.'
        ]);
        self::generateTranslation('settings_description_enable_access_view_video_history', [
            'fr' => 'Affiche l\'accès à l\'historique des vues lorsque son enregistrement est activé.',
            'en' => 'Displays access to view history when recording is enabled.'
        ]);
        self::generateTranslation('settings_description_enable_advertisement', [
            'fr' => 'Affiche les emplacements publicitaires sur le site.',
            'en' => 'Displays advertising placements on the website.'
        ]);
        self::generateTranslation('settings_description_enable_age_restriction', [
            'fr' => 'Applique les restrictions d\'âge aux contenus.',
            'en' => 'Applies age restrictions to content.'
        ]);
        self::generateTranslation('settings_description_enable_all_categ_for_channel', [
            'fr' => 'Enregistre le choix « Toutes » pour les catégories de chaînes ; le code actuel lit le réglage des collections à sa place.',
            'en' => 'Stores the All choice for channel categories; current code reads the collection setting instead.'
        ]);
        self::generateTranslation('settings_description_enable_all_categ_for_collection', [
            'fr' => 'Ajoute le choix « Toutes » dans la navigation par catégories des collections et chaînes.',
            'en' => 'Adds the All choice to category navigation for collections and channels.'
        ]);
        self::generateTranslation('settings_description_enable_all_categ_for_photo', [
            'fr' => 'Ajoute le choix « Toutes » dans la navigation par catégories des photos.',
            'en' => 'Adds the All choice to category navigation for photos.'
        ]);
        self::generateTranslation('settings_description_enable_all_categ_for_video', [
            'fr' => 'Ajoute le choix « Toutes » dans la navigation par catégories des vidéos.',
            'en' => 'Adds the All choice to category navigation for videos.'
        ]);
        self::generateTranslation('settings_description_enable_allow_alias_email', [
            'fr' => 'Accepte les adresses email contenant un alias avec le signe plus.',
            'en' => 'Accepts email addresses containing a plus alias.'
        ]);
        self::generateTranslation('settings_description_enable_anonymous_stats', [
            'fr' => 'Autorise l\'envoi des statistiques anonymes de l\'installation.',
            'en' => 'Allows sending anonymous installation statistics.'
        ]);
        self::generateTranslation('settings_description_enable_blur_restricted_content', [
            'fr' => 'Floute les contenus soumis à une restriction d\'âge au lieu de les masquer.',
            'en' => 'Blurs age-restricted content instead of hiding it.'
        ]);
        self::generateTranslation('settings_description_enable_channel_categories_as_submenu', [
            'fr' => 'Présente les catégories des chaînes dans le sous-menu de navigation.',
            'en' => 'Displays channels categories in the navigation submenu.'
        ]);
        self::generateTranslation('settings_description_enable_channel_description', [
            'fr' => 'Permet de renseigner la description d\'une chaîne.',
            'en' => 'Allows entering a channel description.'
        ]);
        self::generateTranslation('settings_description_enable_channel_slogan', [
            'fr' => 'Permet de renseigner un slogan pour une chaîne.',
            'en' => 'Allows entering a channel slogan.'
        ]);
        self::generateTranslation('settings_description_enable_channels_slogan_display', [
            'fr' => 'Affiche le slogan dans les vignettes des chaînes.',
            'en' => 'Displays the slogan in channel cards.'
        ]);
        self::generateTranslation('settings_description_enable_chunk_upload', [
            'fr' => 'Découpe les envois de fichiers en morceaux pour le transfert.',
            'en' => 'Splits file uploads into chunks for transfer.'
        ]);
        self::generateTranslation('settings_description_enable_collection_backdrop', [
            'fr' => 'Permet de gérer les arrière-plans des collections.',
            'en' => 'Allows managing collection backdrops.'
        ]);
        self::generateTranslation('settings_description_enable_collection_categories', [
            'fr' => 'Active le classement des collections par catégories.',
            'en' => 'Enables organizing collections into categories.'
        ]);
        self::generateTranslation('settings_description_enable_collection_categories_as_submenu', [
            'fr' => 'Présente les catégories des collections dans le sous-menu de navigation.',
            'en' => 'Displays collections categories in the navigation submenu.'
        ]);
        self::generateTranslation('settings_description_enable_collection_internal_sharing', [
            'fr' => 'Permet le partage des collections par message interne.',
            'en' => 'Allows sharing collections through internal messages.'
        ]);
        self::generateTranslation('settings_description_enable_collection_link_sharing', [
            'fr' => 'Permet le partage des collections par lien.',
            'en' => 'Allows sharing collections by link.'
        ]);
        self::generateTranslation('settings_description_enable_collection_poster', [
            'fr' => 'Permet de gérer les affiches des collections.',
            'en' => 'Allows managing collection posters.'
        ]);
        self::generateTranslation('settings_description_enable_comments_censor', [
            'fr' => 'Masque les mots interdits dans les commentaires.',
            'en' => 'Censors prohibited words in comments.'
        ]);
        self::generateTranslation('settings_description_enable_comments_channel', [
            'fr' => 'Autorise les commentaires sur les chaînes.',
            'en' => 'Allows comments on channels.'
        ]);
        self::generateTranslation('settings_description_enable_comments_collection', [
            'fr' => 'Autorise les commentaires sur les collections.',
            'en' => 'Allows comments on collections.'
        ]);
        self::generateTranslation('settings_description_enable_comments_photo', [
            'fr' => 'Autorise les commentaires sur les photos.',
            'en' => 'Allows comments on photos.'
        ]);
        self::generateTranslation('settings_description_enable_comments_video', [
            'fr' => 'Autorise les commentaires sur les vidéos.',
            'en' => 'Allows comments on videos.'
        ]);
        self::generateTranslation('settings_description_enable_cookie_banner', [
            'fr' => 'Affiche le bandeau de consentement et applique les préférences de cookies.',
            'en' => 'Displays the consent banner and applies cookie preferences.'
        ]);
        self::generateTranslation('settings_description_enable_country', [
            'fr' => 'Active le champ « pays » du profil utilisateur.',
            'en' => 'Enables the country field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_country_video_field', [
            'fr' => 'Permet de renseigner le champ « pays » des vidéos.',
            'en' => 'Allows entering the video country field.'
        ]);
        self::generateTranslation('settings_description_enable_dev_mode', [
            'fr' => 'Active le mode développement au moyen du fichier development.dev.',
            'en' => 'Enables development mode through the development.dev file.'
        ]);
        self::generateTranslation('settings_description_enable_edit_button', [
            'fr' => 'Affiche les commandes de modification des vidéos pour les utilisateurs autorisés.',
            'en' => 'Displays video editing controls for permitted users.'
        ]);
        self::generateTranslation('settings_description_enable_edit_photo_button', [
            'fr' => 'Affiche le bouton de modification d\'une photo pour les utilisateurs autorisés.',
            'en' => 'Displays the photo edit button for permitted users.'
        ]);
        self::generateTranslation('settings_description_enable_external_rate_field', [
            'fr' => 'Permet de renseigner la note externe d\'un contenu.',
            'en' => 'Allows entering an external content rating.'
        ]);
        self::generateTranslation('settings_description_enable_external_rate_from_tmdb', [
            'fr' => 'Importe la note moyenne fournie par TMDB.',
            'en' => 'Imports the average rating supplied by TMDB.'
        ]);
        self::generateTranslation('settings_description_enable_external_rate_ratings_on_fo', [
            'fr' => 'Permet de modifier les notes et votes externes depuis le site public.',
            'en' => 'Allows editing external ratings and vote counts from the public website.'
        ]);
        self::generateTranslation('settings_description_enable_external_ratings_field', [
            'fr' => 'Permet de renseigner le nombre de votes externes d\'un contenu.',
            'en' => 'Allows entering an external content vote count.'
        ]);
        self::generateTranslation('settings_description_enable_external_ratings_from_tmdb', [
            'fr' => 'Importe le nombre de votes fourni par TMDB.',
            'en' => 'Imports the vote count supplied by TMDB.'
        ]);
        self::generateTranslation('settings_description_enable_favorite_icon', [
            'fr' => 'Affiche l’icône des favoris sur les vidéos.',
            'en' => 'Displays the favorite icon on videos.'
        ]);
        self::generateTranslation('settings_description_enable_favorite_icon_collection', [
            'fr' => 'Affiche l’icône des favoris sur les collections.',
            'en' => 'Displays the favorite icon on collections.'
        ]);
        self::generateTranslation('settings_description_enable_favorite_icon_photo', [
            'fr' => 'Affiche l’icône des favoris sur les photos.',
            'en' => 'Displays the favorite icon on photos.'
        ]);
        self::generateTranslation('settings_description_enable_featured_collection_hierarchy', [
            'fr' => 'Présente la hiérarchie des collections mises en avant sur l\'accueil.',
            'en' => 'Displays the hierarchy of featured collections on the homepage.'
        ]);
        self::generateTranslation('settings_description_enable_gender', [
            'fr' => 'Active le champ « genre » du profil utilisateur.',
            'en' => 'Enables the gender field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_global_age_restriction', [
            'fr' => 'Restreint globalement l\'accès au site selon l\'âge minimal configuré.',
            'en' => 'Restricts website access globally using the configured minimum age.'
        ]);
        self::generateTranslation('settings_description_enable_hide_uploader_name', [
            'fr' => 'Masque le nom de l\'auteur dans les affichages de contenus concernés.',
            'en' => 'Hides the uploader name in the relevant content displays.'
        ]);
        self::generateTranslation('settings_description_enable_location_video_field', [
            'fr' => 'Permet de renseigner le champ « lieu » des vidéos.',
            'en' => 'Allows entering the video location field.'
        ]);
        self::generateTranslation('settings_description_enable_multi_factor_authentification', [
            'fr' => 'Active l\'authentification multifacteur des comptes.',
            'en' => 'Enables multifactor account authentication.'
        ]);
        self::generateTranslation('settings_description_enable_photo_categories', [
            'fr' => 'Active le classement des photos par catégories.',
            'en' => 'Enables organizing photos into categories.'
        ]);
        self::generateTranslation('settings_description_enable_photo_categories_as_submenu', [
            'fr' => 'Présente les catégories des photos dans le sous-menu de navigation.',
            'en' => 'Displays photos categories in the navigation submenu.'
        ]);
        self::generateTranslation('settings_description_enable_photo_file_upload', [
            'fr' => 'Permet d\'envoyer des fichiers photo depuis l\'ordinateur.',
            'en' => 'Allows uploading photo files from the computer.'
        ]);
        self::generateTranslation('settings_description_enable_profiling', [
            'fr' => 'Active la mesure des performances avec la base de profilage.',
            'en' => 'Enables performance measurement using the profiling database.'
        ]);
        self::generateTranslation('settings_description_enable_public_video_page', [
            'fr' => 'Permet l\'accès public à la page vidéo selon les permissions existantes.',
            'en' => 'Allows public access to the video page under existing permissions.'
        ]);
        self::generateTranslation('settings_description_enable_quicklist', [
            'fr' => 'Permet de constituer une liste rapide de vidéos à regarder.',
            'en' => 'Allows building a quick list of videos to watch.'
        ]);
        self::generateTranslation('settings_description_enable_recorded_date_video_field', [
            'fr' => 'Permet de renseigner le champ « date d’enregistrement » des vidéos.',
            'en' => 'Allows entering the video recording date field.'
        ]);
        self::generateTranslation('settings_description_enable_rss_feeds', [
            'fr' => 'Rend les flux de syndication RSS accessibles.',
            'en' => 'Makes RSS syndication feeds available.'
        ]);
        self::generateTranslation('settings_description_enable_sitemap', [
            'fr' => 'Permet la génération du plan du site pour les moteurs de recherche.',
            'en' => 'Enables sitemap generation for search engines.'
        ]);
        self::generateTranslation('settings_description_enable_social_networks_links_footer', [
            'fr' => 'Affiche les liens vers les réseaux sociaux dans le pied de page.',
            'en' => 'Displays social network links in the footer.'
        ]);
        self::generateTranslation('settings_description_enable_social_networks_links_home_sidebar', [
            'fr' => 'Affiche les liens vers les réseaux sociaux dans la barre latérale de l’accueil.',
            'en' => 'Displays social network links in the homepage sidebar.'
        ]);
        self::generateTranslation('settings_description_enable_storage_history', [
            'fr' => 'Enregistre l\'historique de l\'espace de stockage utilisé.',
            'en' => 'Records storage usage history.'
        ]);
        self::generateTranslation('settings_description_enable_storage_history_fo', [
            'fr' => 'Rend l\'historique du stockage accessible dans l\'espace utilisateur.',
            'en' => 'Makes storage history available in the user area.'
        ]);
        self::generateTranslation('settings_description_enable_sub_collection', [
            'fr' => 'Permet d\'organiser les collections en sous-collections.',
            'en' => 'Allows organizing collections into subcollections.'
        ]);
        self::generateTranslation('settings_description_enable_theme_change', [
            'fr' => 'Permet aux visiteurs de changer le thème visuel.',
            'en' => 'Allows visitors to change the visual theme.'
        ]);
        self::generateTranslation('settings_description_enable_tmdb', [
            'fr' => 'Active la recherche et l\'import de métadonnées depuis TMDB.',
            'en' => 'Enables searching and importing metadata from TMDB.'
        ]);
        self::generateTranslation('settings_description_enable_tmdb_mature_content', [
            'fr' => 'Inclut les contenus pour adultes dans la recherche TMDB.',
            'en' => 'Includes adult content in TMDB searches.'
        ]);
        self::generateTranslation('settings_description_enable_update_checker', [
            'fr' => 'Autorise la vérification des mises à jour de ClipBucket.',
            'en' => 'Allows checking for ClipBucket updates.'
        ]);
        self::generateTranslation('settings_description_enable_user_about', [
            'fr' => 'Active le champ « présentation personnelle » du profil utilisateur.',
            'en' => 'Enables the personal description field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_category', [
            'fr' => 'Active le champ « catégorie » du profil utilisateur.',
            'en' => 'Enables the category field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_city', [
            'fr' => 'Active le champ « ville » du profil utilisateur.',
            'en' => 'Enables the city field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_compagnies', [
            'fr' => 'Active le champ « entreprises » du profil utilisateur.',
            'en' => 'Enables the companies field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_dob_edition', [
            'fr' => 'Permet aux utilisateurs de modifier leur date de naissance.',
            'en' => 'Allows users to edit their date of birth.'
        ]);
        self::generateTranslation('settings_description_enable_user_education', [
            'fr' => 'Active le champ « formation » du profil utilisateur.',
            'en' => 'Enables the education field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_favorite_books', [
            'fr' => 'Active le champ « livres favoris » du profil utilisateur.',
            'en' => 'Enables the favorite books field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_favorite_movies', [
            'fr' => 'Active le champ « films favoris » du profil utilisateur.',
            'en' => 'Enables the favorite movies field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_favorite_music', [
            'fr' => 'Active le champ « musique favorite » du profil utilisateur.',
            'en' => 'Enables the favorite music field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_firstname_lastname', [
            'fr' => 'Active le champ « nom et prénom » du profil utilisateur.',
            'en' => 'Enables the first and last name field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_hobbies', [
            'fr' => 'Active le champ « loisirs » du profil utilisateur.',
            'en' => 'Enables the hobbies field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_hometown', [
            'fr' => 'Active le champ « ville d’origine » du profil utilisateur.',
            'en' => 'Enables the hometown field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_occupation', [
            'fr' => 'Active le champ « profession » du profil utilisateur.',
            'en' => 'Enables the occupation field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_postcode', [
            'fr' => 'Active le champ « code postal » du profil utilisateur.',
            'en' => 'Enables the postal code field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_profil_censor', [
            'fr' => 'Masque les mots interdits dans les textes des profils.',
            'en' => 'Censors prohibited words in profile text.'
        ]);
        self::generateTranslation('settings_description_enable_user_relation_status', [
            'fr' => 'Active le champ « situation familiale » du profil utilisateur.',
            'en' => 'Enables the relationship status field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_schools', [
            'fr' => 'Active le champ « établissements scolaires » du profil utilisateur.',
            'en' => 'Enables the schools field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_self_deletion', [
            'fr' => 'Permet à un utilisateur de supprimer son propre compte.',
            'en' => 'Allows users to delete their own account.'
        ]);
        self::generateTranslation('settings_description_enable_user_status', [
            'fr' => 'Active le champ « statut » du profil utilisateur.',
            'en' => 'Enables the status field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_user_website', [
            'fr' => 'Active le champ « site web » du profil utilisateur.',
            'en' => 'Enables the website field in user profiles.'
        ]);
        self::generateTranslation('settings_description_enable_video_actor', [
            'fr' => 'Active les métadonnées « acteurs » des vidéos.',
            'en' => 'Enables video actors metadata.'
        ]);
        self::generateTranslation('settings_description_enable_video_backdrop', [
            'fr' => 'Permet de gérer les arrière-plans des vidéos.',
            'en' => 'Allows managing video backdrops.'
        ]);
        self::generateTranslation('settings_description_enable_video_categories', [
            'fr' => 'Active le classement des vidéos par catégories.',
            'en' => 'Enables organizing videos into categories.'
        ]);
        self::generateTranslation('settings_description_enable_video_categories_as_submenu', [
            'fr' => 'Présente les catégories des vidéos dans le sous-menu de navigation.',
            'en' => 'Displays videos categories in the navigation submenu.'
        ]);
        self::generateTranslation('settings_description_enable_video_crew', [
            'fr' => 'Active les métadonnées « équipe technique » des vidéos.',
            'en' => 'Enables video crew metadata.'
        ]);
        self::generateTranslation('settings_description_enable_video_description_censor', [
            'fr' => 'Masque les mots interdits dans les descriptions de vidéos.',
            'en' => 'Censors prohibited words in video descriptions.'
        ]);
        self::generateTranslation('settings_description_enable_video_description_link', [
            'fr' => 'Rend les liens des descriptions de vidéos cliquables.',
            'en' => 'Makes links in video descriptions clickable.'
        ]);
        self::generateTranslation('settings_description_enable_video_director', [
            'fr' => 'Active les métadonnées « réalisateurs » des vidéos.',
            'en' => 'Enables video directors metadata.'
        ]);
        self::generateTranslation('settings_description_enable_video_embed_players', [
            'fr' => 'Permet d\'utiliser les lecteurs intégrés externes associés aux vidéos.',
            'en' => 'Allows using external embedded players associated with videos.'
        ]);
        self::generateTranslation('settings_description_enable_video_executive_producer', [
            'fr' => 'Active les métadonnées « producteurs délégués » des vidéos.',
            'en' => 'Enables video executive producers metadata.'
        ]);
        self::generateTranslation('settings_description_enable_video_file_upload', [
            'fr' => 'Permet d\'envoyer des fichiers vidéo depuis l\'ordinateur.',
            'en' => 'Allows uploading video files from the computer.'
        ]);
        self::generateTranslation('settings_description_enable_video_genre', [
            'fr' => 'Active les métadonnées « genres » des vidéos.',
            'en' => 'Enables video genres metadata.'
        ]);
        self::generateTranslation('settings_description_enable_video_internal_sharing', [
            'fr' => 'Permet le partage des vidéos par message interne.',
            'en' => 'Allows sharing videos through internal messages.'
        ]);
        self::generateTranslation('settings_description_enable_video_link_sharing', [
            'fr' => 'Permet le partage des vidéos par lien.',
            'en' => 'Allows sharing videos by link.'
        ]);
        self::generateTranslation('settings_description_enable_video_poster', [
            'fr' => 'Permet de gérer les affiches des vidéos.',
            'en' => 'Allows managing video posters.'
        ]);
        self::generateTranslation('settings_description_enable_video_producer', [
            'fr' => 'Active les métadonnées « producteurs » des vidéos.',
            'en' => 'Enables video producers metadata.'
        ]);
        self::generateTranslation('settings_description_enable_video_remote_play', [
            'fr' => 'Permet d\'ajouter une vidéo lue depuis une adresse distante.',
            'en' => 'Allows adding a video played from a remote address.'
        ]);
        self::generateTranslation('settings_description_enable_video_social_sharing', [
            'fr' => 'Affiche le partage des vidéos sur les réseaux sociaux.',
            'en' => 'Displays video sharing to social networks.'
        ]);
        self::generateTranslation('settings_description_enable_video_thumbs_preview', [
            'fr' => 'Fait défiler les miniatures des vidéos au survol.',
            'en' => 'Cycles through video thumbnail previews on hover.'
        ]);
        self::generateTranslation('settings_description_enable_video_view_history', [
            'fr' => 'Enregistre l\'historique des consultations de vidéos.',
            'en' => 'Records video viewing history.'
        ]);
        self::generateTranslation('settings_description_enable_visual_editor_comments', [
            'fr' => 'Active l\'éditeur visuel des textes dans les formulaires concernés.',
            'en' => 'Enables the visual text editor in the relevant forms.'
        ]);
        self::generateTranslation('settings_description_extract_subtitles', [
            'fr' => 'Extrait les sous-titres de la vidéo dans des fichiers séparés.',
            'en' => 'Extracts video subtitles into separate files.'
        ]);
        self::generateTranslation('settings_description_favicon_name', [
            'fr' => 'Remplace l\'icône du site affichée par le navigateur.',
            'en' => 'Replaces the website icon displayed by the browser.'
        ]);
        self::generateTranslation('settings_description_featured_video_style', [
            'fr' => 'Choisit la présentation des vignettes pour les vidéos mises en avant de l’accueil.',
            'en' => 'Chooses the card layout for featured homepage videos.'
        ]);
        self::generateTranslation('settings_description_feedssection', [
            'fr' => 'Enregistre l’activation du fil d’activité ; aucun effet actuel n’est identifié dans l’application.',
            'en' => 'Stores activity feed activation; no current effect is identified in the application.'
        ]);
        self::generateTranslation('settings_description_ffmpegpath', [
            'fr' => 'Définit le chemin de l’exécutable FFmpeg utilisé par le serveur.',
            'en' => 'Sets the path to the FFmpeg executable used by the server.'
        ]);
        self::generateTranslation('settings_description_ffprobe_path', [
            'fr' => 'Définit le chemin de l’exécutable FFprobe utilisé par le serveur.',
            'en' => 'Sets the path to the FFprobe executable used by the server.'
        ]);
        self::generateTranslation('settings_description_force_8bits', [
            'fr' => 'Limite la profondeur des couleurs vidéo à huit bits pour améliorer la compatibilité.',
            'en' => 'Limits video color depth to eight bits to improve compatibility.'
        ]);
        self::generateTranslation('settings_description_git_path', [
            'fr' => 'Définit le chemin de l’exécutable Git utilisé par le serveur.',
            'en' => 'Sets the path to the Git executable used by the server.'
        ]);
        self::generateTranslation('settings_description_gravatars', [
            'fr' => 'Utilise Gravatar pour les avatars des utilisateurs.',
            'en' => 'Uses Gravatar for user avatars.'
        ]);
        self::generateTranslation('settings_description_hide_empty_collection', [
            'fr' => 'Masque les collections ne contenant aucun élément.',
            'en' => 'Hides collections containing no items.'
        ]);
        self::generateTranslation('settings_description_home_disable_sidebar', [
            'fr' => 'Masque la barre latérale de la page d\'accueil.',
            'en' => 'Hides the homepage sidebar.'
        ]);
        self::generateTranslation('settings_description_home_display_featured_collections', [
            'fr' => 'Affiche les collections mises en avant sur la page d\'accueil.',
            'en' => 'Displays featured collections on the homepage.'
        ]);
        self::generateTranslation('settings_description_home_display_recent_videos', [
            'fr' => 'Affiche les vidéos récentes sur la page d\'accueil.',
            'en' => 'Displays recent videos on the homepage.'
        ]);
        self::generateTranslation('settings_description_home_enable_fullwidth', [
            'fr' => 'Étend la page d’accueil sur toute la largeur disponible.',
            'en' => 'Expands the homepage to the full available width.'
        ]);
        self::generateTranslation('settings_description_homepage_collection_video_ratio', [
            'fr' => 'Choisit le rapport largeur sur hauteur des vignettes des vidéos des collections sur l’accueil.',
            'en' => 'Chooses the thumbnail aspect ratio of collection videos on the homepage.'
        ]);
        self::generateTranslation('settings_description_homepage_collection_video_style', [
            'fr' => 'Choisit la présentation des vignettes pour les vidéos des collections sur l’accueil.',
            'en' => 'Chooses the card layout for homepage collection videos.'
        ]);
        self::generateTranslation('settings_description_homepage_recent_video_ratio', [
            'fr' => 'Choisit le rapport largeur sur hauteur des vignettes des vidéos récentes sur l’accueil.',
            'en' => 'Chooses the thumbnail aspect ratio of recent videos on the homepage.'
        ]);
        self::generateTranslation('settings_description_homepage_recent_video_style', [
            'fr' => 'Choisit la présentation des vignettes pour les vidéos récentes de l’accueil.',
            'en' => 'Chooses the card layout for recent homepage videos.'
        ]);
        self::generateTranslation('settings_description_homepage_recent_videos_display', [
            'fr' => 'Choisit une pagination ou un carrousel pour les vidéos récentes de l\'accueil.',
            'en' => 'Chooses pagination or a slider for recent homepage videos.'
        ]);
        self::generateTranslation('settings_description_keep_audio_tracks', [
            'fr' => 'Conserve les pistes audio dans les fichiers vidéo convertis.',
            'en' => 'Keeps audio tracks in converted video files.'
        ]);
        self::generateTranslation('settings_description_keep_ratio_photo', [
            'fr' => 'Impose le rapport d\'affichage configuré aux photos.',
            'en' => 'Applies the configured display aspect ratio to photos.'
        ]);
        self::generateTranslation('settings_description_keep_subtitles', [
            'fr' => 'Conserve les sous-titres dans les fichiers vidéo convertis.',
            'en' => 'Keeps subtitles in converted video files.'
        ]);
        self::generateTranslation('settings_description_keywords', [
            'fr' => 'Définit les mots-clés des métadonnées du site.',
            'en' => 'Sets website metadata keywords.'
        ]);
        self::generateTranslation('settings_description_limit_photo_related', [
            'fr' => 'Limite le nombre de photos apparentées proposées.',
            'en' => 'Limits the number of related photos offered.'
        ]);
        self::generateTranslation('settings_description_list_featured_videos', [
            'fr' => 'Limite le nombre de vidéos mises en avant sur l’accueil.',
            'en' => 'Limits the number of featured homepage videos.'
        ]);
        self::generateTranslation('settings_description_list_home_collection_videos', [
            'fr' => 'Limite le nombre de vidéos par collection sur l’accueil.',
            'en' => 'Limits the number of videos per homepage collection.'
        ]);
        self::generateTranslation('settings_description_list_recent_videos', [
            'fr' => 'Limite le nombre de vidéos récentes sur l’accueil.',
            'en' => 'Limits the number of recent homepage videos.'
        ]);
        self::generateTranslation('settings_description_logo_name', [
            'fr' => 'Remplace le logo du site par l\'image envoyée.',
            'en' => 'Replaces the website logo with the uploaded image.'
        ]);
        self::generateTranslation('settings_description_mail_type', [
            'fr' => 'Choisit l\'envoi des emails par PHP mail ou par SMTP.',
            'en' => 'Chooses email delivery through PHP mail or SMTP.'
        ]);
        self::generateTranslation('settings_description_main_menu_order', [
            'fr' => 'Définit l\'ordre des sections du menu principal.',
            'en' => 'Sets the order of sections in the main menu.'
        ]);
        self::generateTranslation('settings_description_max_bg_width', [
            'fr' => 'Limite la largeur des images de fond envoyées, en pixels.',
            'en' => 'Limits the width of uploaded background images in pixels.'
        ]);
        self::generateTranslation('settings_description_max_collection_categories', [
            'fr' => 'Limite le nombre de catégories associées à une collection ; zéro désactive cette limite.',
            'en' => 'Limits categories assigned to a collection; zero disables this limit.'
        ]);
        self::generateTranslation('settings_description_max_comment_chr', [
            'fr' => 'Limite la longueur des commentaires en caractères.',
            'en' => 'Limits comment length in characters.'
        ]);
        self::generateTranslation('settings_description_max_conversion', [
            'fr' => 'Limite le nombre de conversions vidéo lancées simultanément.',
            'en' => 'Limits the number of video conversions running simultaneously.'
        ]);
        self::generateTranslation('settings_description_max_photo_categories', [
            'fr' => 'Limite le nombre de catégories associées à une photo ; zéro désactive cette limite.',
            'en' => 'Limits categories assigned to a photo; zero disables this limit.'
        ]);
        self::generateTranslation('settings_description_max_photo_size', [
            'fr' => 'Limite la taille des fichiers photo envoyés, en Mo.',
            'en' => 'Limits uploaded photo file size in MB.'
        ]);
        self::generateTranslation('settings_description_max_profile_pic_width', [
            'fr' => 'Limite la largeur des avatars envoyés, en pixels.',
            'en' => 'Limits the width of uploaded avatars in pixels.'
        ]);
        self::generateTranslation('settings_description_max_upload_size', [
            'fr' => 'Limite la taille des fichiers envoyés, en Mo.',
            'en' => 'Limits uploaded file size in MB.'
        ]);
        self::generateTranslation('settings_description_max_username', [
            'fr' => 'Fixe la longueur maximale de l’identifiant utilisateur, en caractères.',
            'en' => 'Sets the maximum username length in characters.'
        ]);
        self::generateTranslation('settings_description_max_video_desc', [
            'fr' => 'Enregistre le paramètre « longueur maximale de description vidéo » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the maximum video description length setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_max_video_duration', [
            'fr' => 'Limite la durée des vidéos envoyées, en minutes.',
            'en' => 'Limits uploaded video duration in minutes.'
        ]);
        self::generateTranslation('settings_description_max_video_title', [
            'fr' => 'Fixe la longueur maximale du titre vidéo, en caractères.',
            'en' => 'Sets the maximum video title length in characters.'
        ]);
        self::generateTranslation('settings_description_maximum_allowed_subtitle_size', [
            'fr' => 'Limite la taille des fichiers de sous-titres envoyés, en Mo.',
            'en' => 'Limits uploaded subtitle file size in MB.'
        ]);
        self::generateTranslation('settings_description_media_info', [
            'fr' => 'Définit le chemin de l’exécutable MediaInfo utilisé par le serveur.',
            'en' => 'Sets the path to the MediaInfo executable used by the server.'
        ]);
        self::generateTranslation('settings_description_min_age_reg', [
            'fr' => 'Fixe l\'âge minimal en années pour l\'inscription et la restriction globale d\'accès.',
            'en' => 'Sets the minimum age in years for registration and global access restrictions.'
        ]);
        self::generateTranslation('settings_description_min_username', [
            'fr' => 'Fixe la longueur minimale de l’identifiant utilisateur, en caractères.',
            'en' => 'Sets the minimum username length in characters.'
        ]);
        self::generateTranslation('settings_description_min_video_desc', [
            'fr' => 'Enregistre le paramètre « longueur minimale de description vidéo » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the minimum video description length setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_min_video_title', [
            'fr' => 'Fixe la longueur minimale du titre vidéo, en caractères.',
            'en' => 'Sets the minimum video title length in characters.'
        ]);
        self::generateTranslation('settings_description_nginx_path', [
            'fr' => 'Définit le chemin de l’exécutable Nginx utilisé par le serveur.',
            'en' => 'Sets the path to the Nginx executable used by the server.'
        ]);
        self::generateTranslation('settings_description_num_thumbs', [
            'fr' => 'Définit le nombre de miniatures extraites lors du traitement d\'une vidéo.',
            'en' => 'Sets the number of thumbnails extracted during video processing.'
        ]);
        self::generateTranslation('settings_description_only_keep_max_resolution', [
            'fr' => 'Ne conserve que la plus grande résolution vidéo générée.',
            'en' => 'Keeps only the largest generated video resolution.'
        ]);
        self::generateTranslation('settings_description_own_channel_rating', [
            'fr' => 'Permet aux utilisateurs de noter leurs propres chaînes.',
            'en' => 'Allows users to rate their own channels.'
        ]);
        self::generateTranslation('settings_description_own_collection_rating', [
            'fr' => 'Permet aux utilisateurs de noter leurs propres collections.',
            'en' => 'Allows users to rate their own collections.'
        ]);
        self::generateTranslation('settings_description_own_comment_rating', [
            'fr' => 'Permet aux utilisateurs de noter leurs propres commentaires.',
            'en' => 'Allows users to rate their own comments.'
        ]);
        self::generateTranslation('settings_description_own_photo_rating', [
            'fr' => 'Permet aux utilisateurs de noter leurs propres photos.',
            'en' => 'Allows users to rate their own photos.'
        ]);
        self::generateTranslation('settings_description_own_video_rating', [
            'fr' => 'Permet aux utilisateurs de noter leurs propres vidéos.',
            'en' => 'Allows users to rate their own videos.'
        ]);
        self::generateTranslation('settings_description_photo_activation', [
            'fr' => 'Exige l\'approbation d\'une photo avant sa publication.',
            'en' => 'Requires photo approval before publication.'
        ]);
        self::generateTranslation('settings_description_photo_channel_page', [
            'fr' => 'Limite le nombre de photos par chargement sur une chaîne.',
            'en' => 'Limits the number of photos per channel loading batch.'
        ]);
        self::generateTranslation('settings_description_photo_crop', [
            'fr' => 'Active le recadrage lors du redimensionnement des photos.',
            'en' => 'Enables cropping when resizing photos.'
        ]);
        self::generateTranslation('settings_description_photo_enable_nsfw_check', [
            'fr' => 'Analyse les photos envoyées pour détecter un contenu sensible avec AIVision.',
            'en' => 'Analyzes uploaded photos for sensitive content using AIVision.'
        ]);
        self::generateTranslation('settings_description_photo_home_tabs', [
            'fr' => 'Enregistre le paramètre « photos sur l’accueil » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the homepage photos setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_photo_lar_width', [
            'fr' => 'Définit la largeur des grandes images photo en pixels.',
            'en' => 'Sets large photo image width in pixels.'
        ]);
        self::generateTranslation('settings_description_photo_main_list', [
            'fr' => 'Limite le nombre de photos par page des listes et de la gestion.',
            'en' => 'Limits the number of photos per listing and management page.'
        ]);
        self::generateTranslation('settings_description_photo_med_height', [
            'fr' => 'Définit la hauteur des images photo moyennes en pixels.',
            'en' => 'Sets medium photo image height in pixels.'
        ]);
        self::generateTranslation('settings_description_photo_med_width', [
            'fr' => 'Définit la largeur des images photo moyennes en pixels.',
            'en' => 'Sets medium photo image width in pixels.'
        ]);
        self::generateTranslation('settings_description_photo_nsfw_check_model', [
            'fr' => 'Choisit le modèle de détection de contenu sensible pour les photos.',
            'en' => 'Chooses the sensitive content detection model for photos.'
        ]);
        self::generateTranslation('settings_description_photo_other_limit', [
            'fr' => 'Enregistre le paramètre « limite photo complémentaire » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the additional photo limit setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_photo_rating', [
            'fr' => 'Autorise la notation des photos.',
            'en' => 'Allows rating photos.'
        ]);
        self::generateTranslation('settings_description_photo_ratio', [
            'fr' => 'Enregistre le paramètre « rapport de taille photo » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the photo size ratio setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_photo_search_result', [
            'fr' => 'Limite le nombre de photos par page de recherche.',
            'en' => 'Limits the number of photos per search page.'
        ]);
        self::generateTranslation('settings_description_photo_thumb_height', [
            'fr' => 'Définit la hauteur des petites miniatures photo en pixels.',
            'en' => 'Sets small photo thumbnail height in pixels.'
        ]);
        self::generateTranslation('settings_description_photo_thumb_width', [
            'fr' => 'Définit la largeur des petites miniatures photo en pixels.',
            'en' => 'Sets small photo thumbnail width in pixels.'
        ]);
        self::generateTranslation('settings_description_photo_thumbs_format', [
            'fr' => 'Conserve le format photo ou convertit les miniatures en WebP.',
            'en' => 'Keeps the photo format or converts thumbnails to WebP.'
        ]);
        self::generateTranslation('settings_description_photo_user_favorites', [
            'fr' => 'Enregistre le paramètre « photos favorites de l’utilisateur » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the user favorite photos setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_photo_user_photos', [
            'fr' => 'Enregistre le paramètre « photos de l’utilisateur » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the user photos setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_photossection', [
            'fr' => 'Active la section des photos sur le site.',
            'en' => 'Enables the photos section on the website.'
        ]);
        self::generateTranslation('settings_description_photos_enable_fullwidth', [
            'fr' => 'Étend la liste des photos sur toute la largeur disponible.',
            'en' => 'Expands the photo listing to the full available width.'
        ]);
        self::generateTranslation('settings_description_php_path', [
            'fr' => 'Définit le chemin de l’exécutable PHP en ligne de commande utilisé par le serveur.',
            'en' => 'Sets the path to the command-line PHP executable used by the server.'
        ]);
        self::generateTranslation('settings_description_pick_geo_country', [
            'fr' => 'Présélectionne le pays d\'après la géolocalisation de l\'adresse IP.',
            'en' => 'Preselects the country using IP address geolocation.'
        ]);
        self::generateTranslation('settings_description_picture_upload', [
            'fr' => 'Permet d\'envoyer un fichier image comme avatar.',
            'en' => 'Allows uploading an image file as an avatar.'
        ]);
        self::generateTranslation('settings_description_picture_url', [
            'fr' => 'Permet de définir un avatar à partir d\'une adresse d\'image.',
            'en' => 'Allows setting an avatar from an image address.'
        ]);
        self::generateTranslation('settings_description_player-logo_name', [
            'fr' => 'Remplace le logo de la barre de commandes du lecteur.',
            'en' => 'Replaces the player control bar logo.'
        ]);
        self::generateTranslation('settings_description_player_default_resolution', [
            'fr' => 'Choisit la résolution initiale du lecteur parmi les fichiers disponibles.',
            'en' => 'Chooses the initial player resolution from available files.'
        ]);
        self::generateTranslation('settings_description_player_default_resolution_hls', [
            'fr' => 'Enregistre le paramètre « résolution initiale HLS » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the initial HLS resolution setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_player_logo_url', [
            'fr' => 'Définit l\'adresse ouverte par le logo du lecteur.',
            'en' => 'Sets the address opened by the player logo.'
        ]);
        self::generateTranslation('settings_description_player_subtitles', [
            'fr' => 'Permet de sélectionner des sous-titres dans le lecteur.',
            'en' => 'Allows selecting subtitles in the player.'
        ]);
        self::generateTranslation('settings_description_player_thumbnails', [
            'fr' => 'Affiche les aperçus sur la barre de progression du lecteur.',
            'en' => 'Displays thumbnail previews on the player progress bar.'
        ]);
        self::generateTranslation('settings_description_playlistssection', [
            'fr' => 'Active les listes de lecture vidéo.',
            'en' => 'Enables video playlists.'
        ]);
        self::generateTranslation('settings_description_popup_video', [
            'fr' => 'Ouvre les vidéos de l\'accueil dans une fenêtre de lecture superposée.',
            'en' => 'Opens homepage videos in a playback overlay.'
        ]);
        self::generateTranslation('settings_description_profiling_db_host', [
            'fr' => 'Définit le serveur de la base de données de profilage.',
            'en' => 'Sets the profiling database server.'
        ]);
        self::generateTranslation('settings_description_profiling_db_name', [
            'fr' => 'Définit le nom de la base de données de profilage.',
            'en' => 'Sets the profiling database name.'
        ]);
        self::generateTranslation('settings_description_profiling_db_password', [
            'fr' => 'Définit le mot de passe de la base de profilage.',
            'en' => 'Sets the profiling database password.'
        ]);
        self::generateTranslation('settings_description_profiling_db_port', [
            'fr' => 'Définit le port réseau de la base de profilage.',
            'en' => 'Sets the profiling database network port.'
        ]);
        self::generateTranslation('settings_description_profiling_db_user', [
            'fr' => 'Définit l\'identifiant de connexion à la base de profilage.',
            'en' => 'Sets the profiling database login username.'
        ]);
        self::generateTranslation('settings_description_proxy_auth', [
            'fr' => 'Active l\'authentification auprès du serveur mandataire.',
            'en' => 'Enables authentication with the proxy server.'
        ]);
        self::generateTranslation('settings_description_proxy_enable', [
            'fr' => 'Fait passer les requêtes réseau sortantes par un serveur mandataire.',
            'en' => 'Routes outgoing network requests through a proxy server.'
        ]);
        self::generateTranslation('settings_description_proxy_password', [
            'fr' => 'Définit le mot de passe de connexion au serveur mandataire.',
            'en' => 'Sets the proxy server login password.'
        ]);
        self::generateTranslation('settings_description_proxy_port', [
            'fr' => 'Définit le port réseau du serveur mandataire.',
            'en' => 'Sets the proxy server network port.'
        ]);
        self::generateTranslation('settings_description_proxy_url', [
            'fr' => 'Définit l\'adresse du serveur mandataire pour les requêtes réseau.',
            'en' => 'Sets the proxy server address for network requests.'
        ]);
        self::generateTranslation('settings_description_proxy_username', [
            'fr' => 'Définit l\'identifiant de connexion au serveur mandataire.',
            'en' => 'Sets the proxy server login username.'
        ]);
        self::generateTranslation('settings_description_random_photo_order', [
            'fr' => 'Autorise le tri aléatoire des photos.',
            'en' => 'Allows random sorting of photos.'
        ]);
        self::generateTranslation('settings_description_random_video_order', [
            'fr' => 'Autorise le tri aléatoire des vidéos.',
            'en' => 'Allows random sorting of videos.'
        ]);
        self::generateTranslation('settings_description_ratio_photo', [
            'fr' => 'Définit le rapport largeur sur hauteur d\'affichage des photos.',
            'en' => 'Sets the width-to-height display ratio for photos.'
        ]);
        self::generateTranslation('settings_description_resolution_bitrate', [
            'fr' => 'Définit le débit vidéo de cette résolution en bits par seconde.',
            'en' => 'Sets this resolution\'s video bitrate in bits per second.'
        ]);
        self::generateTranslation('settings_description_resolution_enabled', [
            'fr' => 'Active la génération de cette résolution pendant la conversion vidéo.',
            'en' => 'Enables generating this resolution during video conversion.'
        ]);
        self::generateTranslation('settings_description_sbrate', [
            'fr' => 'Définit le débit audio de conversion en bits par seconde.',
            'en' => 'Sets conversion audio bitrate in bits per second.'
        ]);
        self::generateTranslation('settings_description_send_comment_notification', [
            'fr' => 'Envoie un email au propriétaire lorsqu\'un commentaire est publié.',
            'en' => 'Emails the owner when a comment is posted.'
        ]);
        self::generateTranslation('settings_description_seo', [
            'fr' => 'Utilise des adresses réécrites pour les pages du site.',
            'en' => 'Uses rewritten addresses for website pages.'
        ]);
        self::generateTranslation('settings_description_seo_vido_url', [
            'fr' => 'Choisit la forme des adresses réécrites des vidéos.',
            'en' => 'Chooses the format of rewritten video addresses.'
        ]);
        self::generateTranslation('settings_description_show_collapsed_checkboxes', [
            'fr' => 'Présente les choix de catégories dans une liste repliable.',
            'en' => 'Displays category choices in a collapsible list.'
        ]);
        self::generateTranslation('settings_description_site_slogan', [
            'fr' => 'Définit le slogan du site et sa présentation dans les métadonnées sociales.',
            'en' => 'Sets the website slogan and social metadata description.'
        ]);
        self::generateTranslation('settings_description_site_title', [
            'fr' => 'Définit le nom du site utilisé dans les titres et les messages.',
            'en' => 'Sets the website name used in titles and messages.'
        ]);
        self::generateTranslation('settings_description_smtp_auth', [
            'fr' => 'Active l\'authentification auprès du serveur SMTP.',
            'en' => 'Enables authentication with the SMTP server.'
        ]);
        self::generateTranslation('settings_description_smtp_host', [
            'fr' => 'Définit le serveur utilisé pour envoyer les emails par SMTP.',
            'en' => 'Sets the server used to deliver emails through SMTP.'
        ]);
        self::generateTranslation('settings_description_smtp_pass', [
            'fr' => 'Définit le mot de passe de connexion au serveur SMTP.',
            'en' => 'Sets the SMTP server login password.'
        ]);
        self::generateTranslation('settings_description_smtp_port', [
            'fr' => 'Définit le port réseau du serveur SMTP.',
            'en' => 'Sets the SMTP server network port.'
        ]);
        self::generateTranslation('settings_description_smtp_user', [
            'fr' => 'Définit l\'identifiant de connexion au serveur SMTP.',
            'en' => 'Sets the SMTP server login username.'
        ]);
        self::generateTranslation('settings_description_srate', [
            'fr' => 'Définit la fréquence d\'échantillonnage audio de conversion en hertz.',
            'en' => 'Sets conversion audio sample rate in hertz.'
        ]);
        self::generateTranslation('settings_description_stay_mp4', [
            'fr' => 'Conserve les fichiers MP4 envoyés sans reconversion vidéo.',
            'en' => 'Keeps uploaded MP4 files without video reconversion.'
        ]);
        self::generateTranslation('settings_description_store_guest_session', [
            'fr' => 'Conserve les sessions des visiteurs non connectés.',
            'en' => 'Stores sessions for signed-out visitors.'
        ]);
        self::generateTranslation('settings_description_subtitle_format', [
            'fr' => 'Choisit le format des sous-titres conservés ou extraits par FFmpeg.',
            'en' => 'Chooses the format of subtitles kept or extracted by FFmpeg.'
        ]);
        self::generateTranslation('settings_description_thumb_background_color', [
            'fr' => 'Définit la couleur de remplissage autour des miniatures vidéo.',
            'en' => 'Sets the padding color around video thumbnails.'
        ]);
        self::generateTranslation('settings_description_timezone', [
            'fr' => 'Définit le fuseau horaire utilisé par le site.',
            'en' => 'Sets the time zone used by the website.'
        ]);
        self::generateTranslation('settings_description_tmdb_enable_on_front_end', [
            'fr' => 'Autorise l\'utilisation de l\'import TMDB sur le site public.',
            'en' => 'Allows using TMDB import on the public website.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_actors', [
            'fr' => 'Importe les données « acteurs » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports actors data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_age_restriction', [
            'fr' => 'Importe les données « restriction d’âge » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports age restriction data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_backdrop', [
            'fr' => 'Importe les données « arrière-plans » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports backdrops data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_crew', [
            'fr' => 'Importe les données « équipe technique » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports crew data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_description', [
            'fr' => 'Importe les données « description » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports description data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_director', [
            'fr' => 'Importe les données « réalisateurs » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports directors data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_executive_producer', [
            'fr' => 'Importe les données « producteurs délégués » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports executive producers data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_genre', [
            'fr' => 'Importe les données « genres » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports genres data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_poster', [
            'fr' => 'Importe les données « affiches » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports posters data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_producer', [
            'fr' => 'Importe les données « producteurs » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports producers data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_release_date', [
            'fr' => 'Enregistre le choix d’import de date TMDB ; le code actuel importe la date sans consulter ce réglage.',
            'en' => 'Stores the TMDB date import choice; current code imports the date without consulting this setting.'
        ]);
        self::generateTranslation('settings_description_tmdb_get_title', [
            'fr' => 'Importe les données « titre » depuis TMDB lors de la mise à jour du contenu.',
            'en' => 'Imports title data from TMDB when updating content.'
        ]);
        self::generateTranslation('settings_description_tmdb_mature_content_age', [
            'fr' => 'Définit l\'âge en années utilisé pour les contenus TMDB réservés aux adultes.',
            'en' => 'Sets the age in years used for TMDB adult content.'
        ]);
        self::generateTranslation('settings_description_tmdb_search', [
            'fr' => 'Limite le nombre de résultats par page de recherche TMDB.',
            'en' => 'Limits the number of results per TMDB search page.'
        ]);
        self::generateTranslation('settings_description_tmdb_token', [
            'fr' => 'Définit le jeton d\'authentification des requêtes vers TMDB.',
            'en' => 'Sets the authentication token for TMDB requests.'
        ]);
        self::generateTranslation('settings_description_use_backdrop_as_default_thumb', [
            'fr' => 'Autorise, interdit ou impose l\'usage d\'un arrière-plan comme miniature par défaut.',
            'en' => 'Allows, disallows or forces a backdrop as the default thumbnail.'
        ]);
        self::generateTranslation('settings_description_use_subs', [
            'fr' => 'Permet de gérer des sous-catégories.',
            'en' => 'Allows managing subcategories.'
        ]);
        self::generateTranslation('settings_description_users_items_contacts_channel', [
            'fr' => 'Enregistre le paramètre « contacts sur une chaîne » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the channel contacts setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_users_items_search_page', [
            'fr' => 'Limite le nombre de utilisateurs par page de recherche.',
            'en' => 'Limits the number of users per search page.'
        ]);
        self::generateTranslation('settings_description_users_items_subscriptions', [
            'fr' => 'Enregistre le paramètre « abonnements sur une chaîne » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the channel subscriptions setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_vid_cat_height', [
            'fr' => 'Définit la hauteur des miniatures de catégories vidéo en pixels.',
            'en' => 'Sets video category thumbnail height in pixels.'
        ]);
        self::generateTranslation('settings_description_vid_cat_width', [
            'fr' => 'Définit la largeur des miniatures de catégories vidéo en pixels.',
            'en' => 'Sets video category thumbnail width in pixels.'
        ]);
        self::generateTranslation('settings_description_video_categories', [
            'fr' => 'Limite le nombre de catégories associées à une vidéo ; zéro désactive cette limite.',
            'en' => 'Limits categories assigned to a video; zero disables this limit.'
        ]);
        self::generateTranslation('settings_description_video_codec', [
            'fr' => 'Choisit l\'encodeur vidéo utilisé par FFmpeg.',
            'en' => 'Chooses the video encoder used by FFmpeg.'
        ]);
        self::generateTranslation('settings_description_video_download', [
            'fr' => 'Affiche le téléchargement des vidéos téléchargeables.',
            'en' => 'Displays download links for downloadable videos.'
        ]);
        self::generateTranslation('settings_description_video_embed', [
            'fr' => 'Permet de proposer le code d\'intégration des vidéos sur un autre site.',
            'en' => 'Allows offering video embed code for other websites.'
        ]);
        self::generateTranslation('settings_description_video_enable_fullwidth', [
            'fr' => 'Étend la page de lecture vidéo sur toute la largeur disponible.',
            'en' => 'Expands the video watch page to the full available width.'
        ]);
        self::generateTranslation('settings_description_video_enable_nsfw_check', [
            'fr' => 'Analyse les vidéos envoyées pour détecter un contenu sensible avec AIVision.',
            'en' => 'Analyzes uploaded videos for sensitive content using AIVision.'
        ]);
        self::generateTranslation('settings_description_video_list_view_video_history', [
            'fr' => 'Limite le nombre de entrées par page d’historique des vues vidéo.',
            'en' => 'Limits the number of entries per video view history page.'
        ]);
        self::generateTranslation('settings_description_video_nsfw_check_model', [
            'fr' => 'Choisit le modèle de détection de contenu sensible pour les vidéos.',
            'en' => 'Chooses the sensitive content detection model for videos.'
        ]);
        self::generateTranslation('settings_description_video_rating', [
            'fr' => 'Autorise la notation des vidéos.',
            'en' => 'Allows rating videos.'
        ]);
        self::generateTranslation('settings_description_video_remove_black_bars', [
            'fr' => 'Détecte et recadre les bandes noires pendant la conversion vidéo.',
            'en' => 'Detects and crops black bars during video conversion.'
        ]);
        self::generateTranslation('settings_description_video_round_views', [
            'fr' => 'Abrège l\'affichage du nombre de vues des vidéos.',
            'en' => 'Shortens the displayed video view count.'
        ]);
        self::generateTranslation('settings_description_video_thumbs_format', [
            'fr' => 'Choisit le format des images de miniatures vidéo générées.',
            'en' => 'Chooses the image format of generated video thumbnails.'
        ]);
        self::generateTranslation('settings_description_video_thumbs_preview_count', [
            'fr' => 'Limite le nombre de miniatures utilisées pour l\'aperçu au survol.',
            'en' => 'Limits the number of thumbnails used in hover previews.'
        ]);
        self::generateTranslation('settings_description_videossection', [
            'fr' => 'Active la section des vidéos sur le site.',
            'en' => 'Enables the videos section on the website.'
        ]);
        self::generateTranslation('settings_description_videos_enable_fullwidth', [
            'fr' => 'Étend la liste des vidéos sur toute la largeur disponible.',
            'en' => 'Expands the video listing to the full available width.'
        ]);
        self::generateTranslation('settings_description_videos_item_channel_page', [
            'fr' => 'Limite le nombre de vidéos par chargement sur une chaîne.',
            'en' => 'Limits the number of videos per channel loading batch.'
        ]);
        self::generateTranslation('settings_description_videos_items_hme_page', [
            'fr' => 'Limite le nombre de vidéos dans les anciens onglets de l’accueil.',
            'en' => 'Limits the number of videos in legacy homepage tabs.'
        ]);
        self::generateTranslation('settings_description_videos_items_search_page', [
            'fr' => 'Limite le nombre de vidéos par page de recherche.',
            'en' => 'Limits the number of videos per search page.'
        ]);
        self::generateTranslation('settings_description_videos_items_ufav_page', [
            'fr' => 'Enregistre le paramètre « vidéos favorites de l’utilisateur » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the user favorite videos setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_videos_items_uvid_page', [
            'fr' => 'Enregistre le paramètre « vidéos de l’utilisateur » ; son effet actuel n’est pas identifié dans l’application.',
            'en' => 'Stores the user videos setting; its current effect is not identified in the application.'
        ]);
        self::generateTranslation('settings_description_videos_list_per_page', [
            'fr' => 'Limite le nombre de vidéos par page dans les listes.',
            'en' => 'Limits the number of videos per listing page.'
        ]);
        self::generateTranslation('settings_description_videos_video_style', [
            'fr' => 'Choisit la présentation des vignettes pour les liste des vidéos.',
            'en' => 'Chooses the card layout for the video listing.'
        ]);
        self::generateTranslation('settings_description_vrate', [
            'fr' => 'Définit la fréquence cible d\'images vidéo par seconde.',
            'en' => 'Sets the target video frame rate in frames per second.'
        ]);
        self::generateTranslation('settings_title_site_title', [
            'fr' => 'Titre du site',
            'en' => 'Website title'
        ]);
        self::generateTranslation('settings_title_site_slogan', [
            'fr' => 'Slogan du site',
            'en' => 'Website slogan'
        ]);
        self::generateTranslation('settings_title_keywords', [
            'fr' => 'Mots-clés des métadonnées',
            'en' => 'Meta Keywords'
        ]);
        self::generateTranslation('settings_title_description', [
            'fr' => 'Description des métadonnées',
            'en' => 'Meta Description'
        ]);
        self::generateTranslation('settings_title_closed', [
            'fr' => 'Site fermé',
            'en' => 'Website closed'
        ]);
        self::generateTranslation('settings_title_enable_update_checker', [
            'fr' => 'Vérifier les mises à jour',
            'en' => 'Enable update checker'
        ]);
        self::generateTranslation('settings_title_seo', [
            'fr' => 'Adresses réécrites',
            'en' => 'Use SEO Urls'
        ]);
        self::generateTranslation('settings_title_date_format', [
            'fr' => 'Format des dates',
            'en' => 'Date Format'
        ]);
        self::generateTranslation('settings_title_closed_msg', [
            'fr' => 'Message de fermeture',
            'en' => 'Closed message'
        ]);
        self::generateTranslation('settings_title_enable_rss_feeds', [
            'fr' => 'Activer les flux RSS',
            'en' => 'Enable RSS feeds'
        ]);
        self::generateTranslation('settings_title_videossection', [
            'fr' => 'Activer les vidéos',
            'en' => 'Enable Videos'
        ]);
        self::generateTranslation('settings_title_photossection', [
            'fr' => 'Activer les photos',
            'en' => 'Enable Photos'
        ]);
        self::generateTranslation('settings_title_collectionssection', [
            'fr' => 'Activer les collections',
            'en' => 'Enable Collections'
        ]);
        self::generateTranslation('settings_title_channelssection', [
            'fr' => 'Activer les chaînes',
            'en' => 'Enable Channels'
        ]);
        self::generateTranslation('settings_title_enable_advertisement', [
            'fr' => 'Activer la publicité',
            'en' => 'Enable advertisement'
        ]);
        self::generateTranslation('settings_title_feedssection', [
            'fr' => 'Activer le fil d\'activité',
            'en' => 'Enable feeds'
        ]);
        self::generateTranslation('settings_title_allow_registeration', [
            'fr' => 'Activer les inscriptions',
            'en' => 'Enable registrations'
        ]);
        self::generateTranslation('settings_title_use_subs', [
            'fr' => 'Utiliser les sous-catégories',
            'en' => 'Use Sub-Categories'
        ]);
        self::generateTranslation('settings_title_allow_language_change', [
            'fr' => 'Autoriser le changement de langue',
            'en' => 'Allow language change'
        ]);
        self::generateTranslation('settings_title_min_username', [
            'fr' => 'Longueur minimale des identifiants',
            'en' => 'Minimum Username Length'
        ]);
        self::generateTranslation('settings_title_default_country_iso2', [
            'fr' => 'Pays par défaut',
            'en' => 'Default Country'
        ]);
        self::generateTranslation('settings_title_min_age_reg', [
            'fr' => 'Âge minimal d\'inscription',
            'en' => 'Minimum age for registration'
        ]);
        self::generateTranslation('settings_title_gravatars', [
            'fr' => 'Activer Gravatar',
            'en' => 'Enable Gravatars'
        ]);
        self::generateTranslation('settings_title_picture_url', [
            'fr' => 'Autoriser les avatars par adresse',
            'en' => 'Allow picture URL'
        ]);
        self::generateTranslation('settings_title_picture_upload', [
            'fr' => 'Autoriser l\'envoi d\'avatars',
            'en' => 'Allow picture upload'
        ]);
        self::generateTranslation('settings_title_background_url', [
            'fr' => 'Autoriser les fonds par adresse',
            'en' => 'Allow Background URL'
        ]);
        self::generateTranslation('settings_title_pick_geo_country', [
            'fr' => 'Géolocalisation IP',
            'en' => 'IP Geolocalisation'
        ]);
        self::generateTranslation('settings_title_max_username', [
            'fr' => 'Longueur maximale des identifiants',
            'en' => 'Maximum Username Length'
        ]);
        self::generateTranslation('settings_title_email_verification', [
            'fr' => 'Vérification des emails',
            'en' => 'Email verification'
        ]);
        self::generateTranslation('settings_title_background_upload', [
            'fr' => 'Autoriser l\'envoi de fonds',
            'en' => 'Allow background upload'
        ]);
        self::generateTranslation('settings_title_background_color', [
            'fr' => 'Autoriser la couleur de fond',
            'en' => 'Allow background color'
        ]);
        self::generateTranslation('settings_title_email_domain_restriction', [
            'fr' => 'Restriction des domaines email',
            'en' => 'Email domain restriction'
        ]);
        self::generateTranslation('settings_title_max_profile_pic_width', [
            'fr' => 'Largeur maximale des avatars',
            'en' => 'Max profile pic width'
        ]);
        self::generateTranslation('settings_title_max_bg_width', [
            'fr' => 'Largeur maximale des fonds',
            'en' => 'Max Background width'
        ]);
        self::generateTranslation('settings_title_allow_unicode_usernames', [
            'fr' => 'Autoriser les caractères spéciaux dans les identifiants',
            'en' => 'Allow Special Characters in usernames'
        ]);
        self::generateTranslation('settings_title_allow_username_spaces', [
            'fr' => 'Autoriser les espaces dans les identifiants',
            'en' => 'Allow spaces in usernames'
        ]);
        self::generateTranslation('settings_title_video_embed', [
            'fr' => 'Intégration vidéo',
            'en' => 'Embedding'
        ]);
        self::generateTranslation('settings_title_video_download', [
            'fr' => 'Téléchargement',
            'en' => 'Download'
        ]);
        self::generateTranslation('settings_title_seo_vido_url', [
            'fr' => 'Modèle des adresses vidéo réécrites',
            'en' => 'Seo video url pattern'
        ]);
        self::generateTranslation('settings_title_video_round_views', [
            'fr' => 'Arrondir le nombre de vues',
            'en' => 'Round views'
        ]);
        self::generateTranslation('settings_title_vid_cat_width', [
            'fr' => 'Largeur des catégories',
            'en' => 'Category Width'
        ]);
        self::generateTranslation('settings_title_vid_cat_height', [
            'fr' => 'Hauteur des catégories',
            'en' => 'Category height'
        ]);
        self::generateTranslation('settings_title_activation', [
            'fr' => 'Approbation des vidéos',
            'en' => 'Video Activation'
        ]);
        self::generateTranslation('settings_title_video_title_size', [
            'fr' => 'Longueur du titre vidéo',
            'en' => 'Video title size'
        ]);
        self::generateTranslation('settings_title_min_video_title', [
            'fr' => 'Minimum',
            'en' => 'Min'
        ]);
        self::generateTranslation('settings_title_max_video_title', [
            'fr' => 'Maximum',
            'en' => 'Max'
        ]);
        self::generateTranslation('settings_title_video_description_size', [
            'fr' => 'Longueur de la description vidéo',
            'en' => 'Video description size'
        ]);
        self::generateTranslation('settings_title_min_video_desc', [
            'fr' => 'Minimum',
            'en' => 'Min'
        ]);
        self::generateTranslation('settings_title_max_video_desc', [
            'fr' => 'Maximum',
            'en' => 'Max'
        ]);
        self::generateTranslation('settings_title_photo_activation', [
            'fr' => 'Approbation des photos',
            'en' => 'Photo Activation'
        ]);
        self::generateTranslation('settings_title_enable_sub_collection', [
            'fr' => 'Activer les sous-collections',
            'en' => 'Enable Sub-Collections'
        ]);
        self::generateTranslation('settings_title_comments_captcha', [
            'fr' => 'Captcha des commentaires',
            'en' => 'Comments captcha'
        ]);
        self::generateTranslation('settings_title_max_comment_chr', [
            'fr' => 'Longueur maximale des commentaires',
            'en' => 'Maximum Comment Characters'
        ]);
        self::generateTranslation('settings_title_anonym_comments', [
            'fr' => 'Autoriser les commentaires des visiteurs',
            'en' => 'Allow guests to comment'
        ]);
        self::generateTranslation('settings_title_video_rating', [
            'fr' => 'Notation des vidéos',
            'en' => 'Video rating'
        ]);
        self::generateTranslation('settings_title_photo_rating', [
            'fr' => 'Notation des photos',
            'en' => 'Photo rating'
        ]);
        self::generateTranslation('settings_title_own_video_rating', [
            'fr' => 'Noter ses propres vidéos',
            'en' => 'Rate own video'
        ]);
        self::generateTranslation('settings_title_own_photo_rating', [
            'fr' => 'Noter ses propres photos',
            'en' => 'Rate own photo'
        ]);
        self::generateTranslation('settings_title_collection_rating', [
            'fr' => 'Notation des collections',
            'en' => 'Collection rating'
        ]);
        self::generateTranslation('settings_title_channel_rating', [
            'fr' => 'Notation des chaînes',
            'en' => 'Channel rating'
        ]);
        self::generateTranslation('settings_title_own_collection_rating', [
            'fr' => 'Noter ses propres collections',
            'en' => 'Rate own collection'
        ]);
        self::generateTranslation('settings_title_own_channel_rating', [
            'fr' => 'Noter sa propre chaîne',
            'en' => 'Rate own channel'
        ]);
        self::generateTranslation('settings_title_comment_rating', [
            'fr' => 'Notation des commentaires',
            'en' => 'Comments rating'
        ]);
        self::generateTranslation('settings_title_videos_list_per_page', [
            'fr' => 'Par page',
            'en' => 'Per page'
        ]);
        self::generateTranslation('settings_title_videos_items_ufav_page', [
            'fr' => 'Favoris',
            'en' => 'Favorites'
        ]);
        self::generateTranslation('settings_title_videos_items_hme_page', [
            'fr' => 'Onglets de l\'accueil',
            'en' => 'Home Tabs'
        ]);
        self::generateTranslation('settings_title_videos_item_channel_page', [
            'fr' => 'Page de chaîne',
            'en' => 'Channel page'
        ]);
        self::generateTranslation('settings_title_videos_items_search_page', [
            'fr' => 'Résultats de recherche',
            'en' => 'Search Result'
        ]);
        self::generateTranslation('settings_title_videos_items_uvid_page', [
            'fr' => 'Vidéos de l\'utilisateur',
            'en' => 'User Videos'
        ]);
        self::generateTranslation('settings_title_photo_main_list', [
            'fr' => 'Limite principale',
            'en' => 'Main Limit'
        ]);
        self::generateTranslation('settings_title_photo_home_tabs', [
            'fr' => 'Onglets de l\'accueil',
            'en' => 'Home Tabs'
        ]);
        self::generateTranslation('settings_title_photo_search_result', [
            'fr' => 'Résultats de recherche',
            'en' => 'Search Result'
        ]);
        self::generateTranslation('settings_title_photo_channel_page', [
            'fr' => 'Page de chaîne',
            'en' => 'Channel Page'
        ]);
        self::generateTranslation('settings_title_photo_user_photos', [
            'fr' => 'Photos de l\'utilisateur',
            'en' => 'User Photos'
        ]);
        self::generateTranslation('settings_title_photo_user_favorites', [
            'fr' => 'Favoris de l\'utilisateur',
            'en' => 'User favorites'
        ]);
        self::generateTranslation('settings_title_photo_other_limit', [
            'fr' => 'Autre limite',
            'en' => 'Other Limit'
        ]);
        self::generateTranslation('settings_title_collection_per_page', [
            'fr' => 'Page des collections',
            'en' => 'Collection Page'
        ]);
        self::generateTranslation('settings_title_collection_items_page', [
            'fr' => 'Page des éléments',
            'en' => 'Items Page'
        ]);
        self::generateTranslation('settings_title_collection_search_result', [
            'fr' => 'Résultats de recherche',
            'en' => 'Search Result'
        ]);
        self::generateTranslation('settings_title_collection_home_top_collections', [
            'fr' => 'Collections mises en avant sur l\'accueil',
            'en' => 'Homepage Top Collections'
        ]);
        self::generateTranslation('settings_title_collection_collection_top_collections', [
            'fr' => 'Collections mises en avant sur la page collection',
            'en' => 'Collections page Top Collections'
        ]);
        self::generateTranslation('settings_title_collection_photos_top_collections', [
            'fr' => 'Collections mises en avant sur la page photo',
            'en' => 'Photos page Top Collections'
        ]);
        self::generateTranslation('settings_title_channels_list_per_page', [
            'fr' => 'Par page',
            'en' => 'Per page'
        ]);
        self::generateTranslation('settings_title_users_items_subscriptions', [
            'fr' => 'Abonnements sur la chaîne',
            'en' => 'Subscriptions in channel view'
        ]);
        self::generateTranslation('settings_title_users_items_search_page', [
            'fr' => 'Page de recherche',
            'en' => 'Search Page'
        ]);
        self::generateTranslation('settings_title_users_items_contacts_channel', [
            'fr' => 'Contacts sur la chaîne',
            'en' => 'Users contacts in channel view'
        ]);
        self::generateTranslation('settings_title_comments_per_page', [
            'fr' => 'Commentaires par page',
            'en' => 'Comments per page'
        ]);
        self::generateTranslation('settings_title_embed_player_width', [
            'fr' => 'Largeur du lecteur intégré',
            'en' => 'Embed Player default Width'
        ]);
        self::generateTranslation('settings_title_embed_player_height', [
            'fr' => 'Hauteur du lecteur intégré',
            'en' => 'Embed Player default Height'
        ]);
        self::generateTranslation('settings_title_autoplay_embed', [
            'fr' => 'Lecture automatique intégrée',
            'en' => 'Autoplay Embed'
        ]);
        self::generateTranslation('settings_title_control_bar_logo', [
            'fr' => 'Activer le logo du lecteur',
            'en' => 'Enable Controls bar logo'
        ]);
        self::generateTranslation('settings_title_upload_player-logo', [
            'fr' => 'Logo du lecteur',
            'en' => 'Controls bar logo'
        ]);
        self::generateTranslation('settings_title_player_logo_url', [
            'fr' => 'Adresse du logo du lecteur',
            'en' => 'Controls bar logo URL'
        ]);
        self::generateTranslation('settings_title_autoplay_video', [
            'fr' => 'Lecture automatique',
            'en' => 'Autoplay'
        ]);
        self::generateTranslation('settings_title_chromecast', [
            'fr' => 'Activer Chromecast',
            'en' => 'Enable Chromecast support'
        ]);
        self::generateTranslation('settings_title_player_subtitles', [
            'fr' => 'Activer les sous-titres',
            'en' => 'Enable subtitles'
        ]);
        self::generateTranslation('settings_title_player_default_resolution', [
            'fr' => 'Résolution vidéo par défaut',
            'en' => 'Default video resolution'
        ]);
        self::generateTranslation('settings_title_contextual_menu_disabled', [
            'fr' => 'Désactiver le menu contextuel',
            'en' => 'Disable contextual menu'
        ]);
        self::generateTranslation('settings_title_player_thumbnails', [
            'fr' => 'Miniatures',
            'en' => 'Thumbnails'
        ]);
        self::generateTranslation('settings_title_player_default_resolution_hls', [
            'fr' => 'Résolution HLS par défaut',
            'en' => 'Default HLS video resolution'
        ]);
        self::generateTranslation('settings_title_enable_video_file_upload', [
            'fr' => 'Activer l\'envoi de fichiers vidéo',
            'en' => 'Enable video file upload'
        ]);
        self::generateTranslation('settings_title_delete_mass_upload', [
            'fr' => 'Supprimer les sources de l\'envoi en masse',
            'en' => 'Delete Mass upload'
        ]);
        self::generateTranslation('settings_title_max_video_duration', [
            'fr' => 'Durée vidéo maximale',
            'en' => 'Max video duration'
        ]);
        self::generateTranslation('settings_title_enable_photo_file_upload', [
            'fr' => 'Activer l\'envoi de fichiers photo',
            'en' => 'Enable photo file upload'
        ]);
        self::generateTranslation('settings_title_chunk_upload_size', [
            'fr' => 'Taille des morceaux',
            'en' => 'Chunk size'
        ]);
        self::generateTranslation('settings_title_num_thumbs', [
            'fr' => 'Nombre de miniatures vidéo',
            'en' => 'Number of video thumbs'
        ]);
        self::generateTranslation('settings_title_srate', [
            'fr' => 'Fréquence audio',
            'en' => 'Audio Rate'
        ]);
        self::generateTranslation('settings_title_sbrate', [
            'fr' => 'Débit audio',
            'en' => 'Audio Bitrate'
        ]);
        self::generateTranslation('settings_title_vrate', [
            'fr' => 'Fréquence d\'images cible',
            'en' => 'Frame rate target'
        ]);
        self::generateTranslation('settings_title_video_codec', [
            'fr' => 'Codec vidéo',
            'en' => 'Video Codec'
        ]);
        self::generateTranslation('settings_title_audio_codec', [
            'fr' => 'Codec audio',
            'en' => 'Audio Codec'
        ]);
        self::generateTranslation('settings_title_subtitle_format', [
            'fr' => 'Format des sous-titres',
            'en' => 'Subtitle Format'
        ]);
        self::generateTranslation('settings_title_chromecast_fix', [
            'fr' => 'Compatibilité Chromecast',
            'en' => 'Chromecast compatibility'
        ]);
        self::generateTranslation('settings_title_force_8bits', [
            'fr' => 'Améliorer la compatibilité',
            'en' => 'Improve compatibility'
        ]);
        self::generateTranslation('settings_title_extract_subtitles', [
            'fr' => 'Extraire les sous-titres',
            'en' => 'Extract subtitles'
        ]);
        self::generateTranslation('settings_title_conversion_type', [
            'fr' => 'Type de conversion',
            'en' => 'Conversion type'
        ]);
        self::generateTranslation('settings_title_convesion_type_mp4', [
            'fr' => 'MP4',
            'en' => 'MP4'
        ]);
        self::generateTranslation('settings_title_convesion_type_hls', [
            'fr' => 'HLS',
            'en' => 'HLS'
        ]);
        self::generateTranslation('settings_title_stay_mp4', [
            'fr' => 'Conserver les MP4 d\'origine',
            'en' => 'Stay MP4 as it is'
        ]);
        self::generateTranslation('settings_title_keep_audio_tracks', [
            'fr' => 'Conserver les pistes audio',
            'en' => 'Keep audio tracks'
        ]);
        self::generateTranslation('settings_title_keep_subtitles', [
            'fr' => 'Conserver les sous-titres',
            'en' => 'Keep subtitles'
        ]);
        self::generateTranslation('settings_title_allow_conversion_1_percent', [
            'fr' => 'Tolérer un écart de 1 %',
            'en' => 'Allow 1% difference'
        ]);
        self::generateTranslation('settings_title_send_comment_notification', [
            'fr' => 'Notifier les commentaires',
            'en' => 'Send Comment Notification'
        ]);
        self::generateTranslation('settings_title_approve_video_notification', [
            'fr' => 'Notifier l\'approbation vidéo',
            'en' => 'Send Video Approve Notification'
        ]);
        self::generateTranslation('settings_title_mail_type', [
            'fr' => 'Mode d\'envoi des emails',
            'en' => 'Mailer'
        ]);
        self::generateTranslation('settings_title_smtp_host', [
            'fr' => 'Serveur SMTP',
            'en' => 'SMTP Host'
        ]);
        self::generateTranslation('settings_title_smtp_port', [
            'fr' => 'Port SMTP',
            'en' => 'SMTP Port'
        ]);
        self::generateTranslation('settings_title_smtp_auth', [
            'fr' => 'Authentification SMTP',
            'en' => 'SMTP Auth'
        ]);
        self::generateTranslation('settings_title_smtp_user', [
            'fr' => 'Identifiant SMTP',
            'en' => 'SMTP Username'
        ]);
        self::generateTranslation('settings_title_smtp_pass', [
            'fr' => 'Mot de passe SMTP',
            'en' => 'SMTP Password'
        ]);
        self::generateTranslation('settings_title_proxy_enable', [
            'fr' => 'Activer le serveur mandataire',
            'en' => 'Enable proxy'
        ]);
        self::generateTranslation('settings_title_proxy_auth', [
            'fr' => 'Authentification du serveur mandataire',
            'en' => 'Enable proxy authentification'
        ]);
        self::generateTranslation('settings_title_proxy_url', [
            'fr' => 'Adresse',
            'en' => 'URL'
        ]);
        self::generateTranslation('settings_title_proxy_username', [
            'fr' => 'Identifiant',
            'en' => 'Username'
        ]);
        self::generateTranslation('settings_title_proxy_port', [
            'fr' => 'Port',
            'en' => 'Port'
        ]);
        self::generateTranslation('settings_title_proxy_password', [
            'fr' => 'Mot de passe',
            'en' => 'Password'
        ]);
        self::generateTranslation('settings_title_php_path', [
            'fr' => 'Chemin PHP',
            'en' => 'PHP Path'
        ]);
        self::generateTranslation('settings_title_media_info', [
            'fr' => 'Chemin MediaInfo',
            'en' => 'Mediainfo Path'
        ]);
        self::generateTranslation('settings_title_ffmpegpath', [
            'fr' => 'Chemin FFmpeg',
            'en' => 'FFmpeg Path'
        ]);
        self::generateTranslation('settings_title_ffprobe_path', [
            'fr' => 'Chemin FFprobe',
            'en' => 'FFprobe Path'
        ]);
        self::generateTranslation('settings_title_max_conversion', [
            'fr' => 'Conversions vidéo simultanées',
            'en' => 'Max videos to convert at once'
        ]);
        self::generateTranslation('settings_title_store_guest_session', [
            'fr' => 'Conserver les sessions des visiteurs',
            'en' => 'Store guest Session'
        ]);
        self::generateTranslation('settings_title_bits_color_warning', [
            'fr' => 'Avertissement de compatibilité vidéo au-delà de huit bits',
            'en' => 'Video compatibility warning above eight bits'
        ]);
        self::generateTranslation('settings_search_label', [
            'fr' => 'Rechercher un réglage',
            'en' => 'Search settings'
        ]);
        self::generateTranslation('settings_search_previous', [
            'fr' => 'Précédent',
            'en' => 'Previous'
        ]);
        self::generateTranslation('settings_search_next', [
            'fr' => 'Suivant',
            'en' => 'Next'
        ]);
        self::generateTranslation('settings_search_empty', [
            'fr' => 'Aucun résultat',
            'en' => 'No results'
        ]);
        self::generateTranslation('settings_search_first', [
            'fr' => 'Premier résultat atteint',
            'en' => 'First result reached'
        ]);
        self::generateTranslation('settings_search_last', [
            'fr' => 'Dernier résultat atteint',
            'en' => 'Last result reached'
        ]);
        self::generateTranslation('settings_search_reset', [
            'fr' => 'Réinitialiser la recherche',
            'en' => 'Clear search'
        ]);
        self::generateTranslation('settings_search_tab_result', [
            'fr' => 'Il y a %s résultat dans cet onglet',
            'en' => 'There is %s result in this tab'
        ]);
        self::generateTranslation('settings_search_tab_results', [
            'fr' => 'Il y a %s résultats dans cet onglet',
            'en' => 'There are %s results in this tab'
        ]);
    }
}
