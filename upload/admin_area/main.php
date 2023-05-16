<?php

require_once '../includes/admin_config.php';
global $userquery,$pages,$Upload,$myquery;
$userquery->admin_login_check();
$userquery->login_check('web_config_access');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = array('title' => 'General Configurations', 'url' => '');
$breadcrumb[1] = array('title' => 'Website Configurations', 'url' => ADMIN_BASEURL.'/main.php');

if(@$_GET['msg']){
    $msg = mysql_clean($_GET['msg']);
}

$opt_list = $Upload->load_upload_options();

assign('opt_list',$opt_list);
assign('post_max_size',ini_get('post_max_size'));
assign('upload_max_size',ini_get('upload_max_filesize'));

if(isset($_POST['update']))
{
    $config_booleans = [
        'seo'
        ,'store_guest_session'
        ,'videosSection'
        ,'photosSection'
        ,'collectionsSection'
        ,'channelsSection'
        ,'enable_advertisement'
        ,'use_cached_pagin'
        ,'gravatars'
        ,'picture_url'
        ,'picture_upload'
        ,'background_url'
        ,'background_upload'
        ,'background_color'
        ,'allow_unicode_usernames'
        ,'allow_username_spaces'
        ,'feedsSection'
        ,'stay_mp4'
        ,'delete_mass_upload'
        ,'enable_video_file_upload'
        ,'enable_video_remote_upload'
        ,'enable_photo_file_upload'
        ,'send_comment_notification'
        ,'approve_video_notification'
        ,'smtp_auth'
        ,'video_round_views'
        ,'anonym_comments'
        ,'popup_video'
        ,'proxy_enable'
        ,'proxy_auth'
    ];

    $config_booleans_to_refactor = [
        'closed'
        ,'enable_update_checker'
        ,'allow_language_change'
        ,'allow_registeration'
        ,'allow_template_change'
        ,'pick_geo_country'
        ,'email_verification'
        ,'show_collapsed_checkboxes'
        ,'use_subs'
        ,'activation'
        ,'chromecast_fix'
        ,'photo_activation'
        ,'force_8bits'
        ,'video_embed'
        ,'video_download'
        ,'bits_color_warning'
        ,'video_comments'
        ,'photo_comments'
        ,'channel_comments'
        ,'video_rating'
        ,'own_video_rating'
        ,'photo_rating'
        ,'own_photo_rating'
        ,'comment_rating'
        ,'collection_rating'
        ,'own_collection_rating'
        ,'channel_rating'
        ,'own_channel_rating'
        ,'keep_audio_tracks'
        ,'keep_subtitles'
        ,'extract_subtitles'
        ,'enable_sub_collection'
        ,'photo_crop'
    ];

    $rows = array(
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

        'embed_type',

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
        'youtube_api_key',
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
        'proxy_password'
    );

    foreach($opt_list as $optl) {
        $rows[] = $optl['load_func'];
    }

    //Numeric Array
    $num_array = array(
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
        'photo_med_height'
    );

    foreach($rows as $field) {
        $value = ($_POST[$field]);
        if(in_array($field,$num_array)) {
            if($value <= 0 || !is_numeric($value)){
                $value = 1;
            }
        }
        if( in_array($field, $config_booleans) ){
            if( $value != 'yes' ){
                $value = 'no';
            }
        }
        if( in_array($field, $config_booleans_to_refactor) ){
            if( $value != '1' ){
                $value = '0';
            }
        }

        $myquery->Set_Website_Details($field,$value);
    }

    $myquery->saveVideoResolutions($_POST);
    e('Website settings have been updated','m');
}

$row = $myquery->Get_Website_Details();
Assign('row',$row);

$video_resolutions = $myquery->getVideoResolutions();
Assign('video_resolutions',$video_resolutions);

$ffmpeg_version = check_version('ffmpeg');
Assign('ffmpeg_version',$ffmpeg_version);

subtitle('Website Configurations');
template_files('main.html');
display_it();
