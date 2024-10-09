CREATE TABLE `{tbl_prefix}action_log` (
  `action_id` int(255) NOT NULL,
  `action_type` varchar(60) NOT NULL,
  `action_username` varchar(60) NOT NULL,
  `action_userid` int(30) NOT NULL,
  `action_useremail` varchar(200) NOT NULL,
  `action_userlevel` int(11) NOT NULL,
  `action_ipv4` varchar(15) NULL DEFAULT NULL,
  `action_ipv6` varchar(45) NULL DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action_success` enum('yes','no') DEFAULT NULL,
  `action_details` text NOT NULL,
  `action_obj_id` int(255) NOT NULL,
  `action_done_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}admin_notes` (
  `note_id` int(225) NOT NULL,
  `note` text CHARACTER SET ucs2 NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}admin_todo` (
  `todo_id` int(225) NOT NULL,
  `todo` text CHARACTER SET ucs2 NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}ads_data` (
  `ad_id` int(50) NOT NULL,
  `ad_name` mediumtext NOT NULL,
  `ad_code` mediumtext NOT NULL,
  `ad_placement` varchar(50) NOT NULL DEFAULT '',
  `ad_status` enum('0','1') NOT NULL DEFAULT '0',
  `ad_impressions` bigint(255) NOT NULL DEFAULT 0,
  `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}ads_placements` (
  `placement_id` int(20) NOT NULL,
  `placement` varchar(26) NOT NULL,
  `placement_name` varchar(50) NOT NULL,
  `disable` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}collections` (
  `collection_id` bigint(25) NOT NULL,
  `collection_id_parent` BIGINT(25) NULL DEFAULT NULL,
  `collection_name` varchar(225) NOT NULL,
  `collection_description` text NOT NULL,
  `userid` int(10) NOT NULL,
  `date_added` datetime NOT NULL,
  `featured` varchar(4) NOT NULL DEFAULT 'no',
  `broadcast` varchar(10) NOT NULL,
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` bigint(20) NOT NULL DEFAULT 0,
  `last_commented` datetime DEFAULT NULL,
  `rating` bigint(20) NOT NULL DEFAULT 0,
  `rated_by` bigint(20) NOT NULL DEFAULT 0,
  `voters` longtext DEFAULT NULL,
  `active` varchar(4) NOT NULL,
  `public_upload` varchar(4) NOT NULL,
  `type` ENUM('photos', 'videos') NOT NULL,
  `thumb_objectid` BIGINT(20) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}collection_items` (
  `ci_id` bigint(20) NOT NULL,
  `collection_id` bigint(20) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `type` ENUM('photos', 'videos') NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}comments` (
  `comment_id` int(60) NOT NULL,
  `type` varchar(16) NOT NULL,
  `comment` text NOT NULL,
  `userid` int(60) NULL DEFAULT NULL,
  `anonym_name` varchar(255) NOT NULL,
  `anonym_email` varchar(255) NOT NULL,
  `parent_id` int(60) NOT NULL,
  `type_id` int(225) NOT NULL,
  `type_owner_id` int(255) NOT NULL,
  `vote` varchar(225) NOT NULL DEFAULT '',
  `voters` text NULL DEFAULT NULL,
  `spam_votes` bigint(20) NOT NULL DEFAULT 0,
  `spam_voters` text NULL DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `comment_ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}config` (
  `configid` int(20) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}contacts` (
  `contact_id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `contact_userid` int(225) NOT NULL,
  `confirmed` enum('yes','no') NOT NULL DEFAULT 'no',
  `contact_group_id` int(255) NOT NULL DEFAULT 0,
  `request_type` enum('in','out') NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}conversion_queue` (
  `cqueue_id` int(11) NOT NULL,
  `cqueue_name` varchar(32) NOT NULL,
  `cqueue_ext` varchar(5) NOT NULL,
  `cqueue_tmp_ext` varchar(3) NOT NULL,
  `cqueue_conversion` enum('yes','no','p') NOT NULL DEFAULT 'no',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_started` varchar(32) NOT NULL DEFAULT '0',
  `time_completed` varchar(32) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}counters` (
  `counter_id` int(100) NOT NULL,
  `section` varchar(200) NOT NULL,
  `query` text NOT NULL,
  `query_md5` varchar(200) NOT NULL,
  `counts` bigint(200) NOT NULL,
  `date_added` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}countries` (
  `country_id` int(80) NOT NULL,
  `iso2` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `name_en` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}email_templates` (
  `email_template_id` int(11) NOT NULL,
  `email_template_name` varchar(225) NOT NULL,
  `email_template_code` varchar(225) NOT NULL,
  `email_template_subject` mediumtext NOT NULL,
  `email_template` text NOT NULL,
  `email_template_allowed_tags` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}favorites` (
  `favorite_id` int(225) NOT NULL,
  `type` varchar(4) NOT NULL,
  `id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}flags` (
  `flag_id` int(225) NOT NULL,
  `type` varchar(4) NOT NULL,
  `id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `flag_type` bigint(25) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}languages` (
  `language_id` int(9) NOT NULL,
  `language_name` varchar(20) NOT NULL DEFAULT '0',
  `language_code` varchar(5) NOT NULL UNIQUE ,
  `language_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `language_default` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}mass_emails` (
  `id` int(255) NOT NULL,
  `email_subj` varchar(255) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_msg` text NOT NULL,
  `configs` text NOT NULL,
  `sent` bigint(255) NOT NULL,
  `total` bigint(20) NOT NULL,
  `users` text NOT NULL,
  `start_index` bigint(255) NOT NULL,
  `method` enum('browser','background') NOT NULL,
  `status` enum('completed','pending','sending') NOT NULL,
  `date_added` datetime NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}messages` (
  `message_id` int(225) NOT NULL,
  `message_from` int(20) NOT NULL,
  `message_to` varchar(200) NOT NULL,
  `message_content` mediumtext NOT NULL,
  `message_type` enum('pm','notification') NOT NULL DEFAULT 'pm',
  `message_attachments` mediumtext NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_subject` mediumtext NOT NULL,
  `message_status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `reply_to` int(225) NOT NULL DEFAULT 0,
  `message_box` enum('in','out') NOT NULL DEFAULT 'in'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}pages` (
  `page_id` int(11) NOT NULL,
  `page_order` bigint(100) NOT NULL,
  `display` enum('yes','no') NOT NULL DEFAULT 'yes',
  `page_name` varchar(225) NOT NULL,
  `page_title` varchar(225) NOT NULL,
  `page_content` text NOT NULL,
  `userid` int(225) NOT NULL,
  `active` enum('yes','no') NOT NULL,
  `delete_able` enum('yes','no') NOT NULL DEFAULT 'yes',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}photos` (
  `photo_id` bigint(255) NOT NULL,
  `photo_key` mediumtext NOT NULL,
  `photo_title` mediumtext NOT NULL,
  `photo_description` mediumtext NOT NULL,
  `userid` int(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `views` bigint(255) NOT NULL DEFAULT 0,
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_embedding` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_tagging` enum('yes','no') NOT NULL DEFAULT 'yes',
  `featured` enum('yes','no') NOT NULL DEFAULT 'no',
  `reported` enum('yes','no') NOT NULL DEFAULT 'no',
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `broadcast` enum('public','private') NOT NULL DEFAULT 'public',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` int(255) NOT NULL DEFAULT 0,
  `last_commented` datetime DEFAULT NULL,
  `total_favorites` int(255) NOT NULL DEFAULT 0,
  `rating` int(15) NOT NULL DEFAULT 0,
  `rated_by` int(25) NOT NULL DEFAULT 0,
  `voters` mediumtext DEFAULT NULL,
  `filename` varchar(100) NOT NULL,
  `file_directory` varchar(25) NOT NULL,
  `ext` char(5) NOT NULL,
  `downloaded` bigint(255) NOT NULL DEFAULT 0,
  `server_url` text NULL DEFAULT NULL,
  `owner_ip` varchar(20) NOT NULL,
  `photo_details` text NULL DEFAULT NULL,
  `age_restriction` INT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}playlists` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(225) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT 0,
  `playlist_type` varchar(10) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `tags` mediumtext NOT NULL,
  `privacy` enum('public','private','unlisted') NOT NULL DEFAULT 'public',
  `total_items` int(255) NOT NULL DEFAULT 0,
  `last_update` text NULL DEFAULT NULL,
  `runtime` int(200) NOT NULL DEFAULT 0,
  `first_item` text NULL DEFAULT NULL,
  `cover` text NULL DEFAULT NULL,
  `played` int(255) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}playlist_items` (
  `playlist_item_id` int(225) NOT NULL,
  `object_id` int(225) NOT NULL,
  `playlist_id` int(225) NOT NULL,
  `playlist_item_type` varchar(10) NOT NULL,
  `userid` int(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}plugins` (
  `plugin_id` int(255) NOT NULL,
  `plugin_file` text NOT NULL,
  `plugin_folder` text NOT NULL,
  `plugin_version` varchar(32) NOT NULL,
  `plugin_active` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}plugin_config` (
  `plugin_config_id` int(223) NOT NULL,
  `plugin_id_code` varchar(25) NOT NULL,
  `plugin_config_name` text NOT NULL,
  `plugin_config_value` text NOT NULL,
  `player_type` enum('built-in','plugin') NOT NULL DEFAULT 'built-in',
  `player_admin_file` text NOT NULL,
  `player_include_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}sessions` (
  `session_id` int(11) NOT NULL,
  `session` varchar(100) NOT NULL,
  `session_user` int(11) NOT NULL,
  `session_string` varchar(60) NOT NULL,
  `session_value` varchar(32) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `session_date` datetime NOT NULL,
  `current_page` text NOT NULL,
  `referer` text NOT NULL,
  `agent` text NOT NULL,
  `last_active` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}stats` (
  `stat_id` int(255) NOT NULL,
  `date_added` date NOT NULL,
  `video_stats` text NOT NULL,
  `user_stats` text NOT NULL,
  `group_stats` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}subscriptions` (
  `subscription_id` int(225) NOT NULL,
  `userid` int(11) NOT NULL,
  `subscribed_to` mediumtext NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}template` (
  `template_id` int(20) NOT NULL,
  `template_name` varchar(25) NOT NULL,
  `template_dir` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}users` (
  `userid` bigint(20) NOT NULL,
  `featured_video` mediumtext NOT NULL,
  `username` text NOT NULL,
  `user_session_key` varchar(32) NOT NULL,
  `user_session_code` int(5) NOT NULL,
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `usr_status` enum('Ok','ToActivate') NOT NULL DEFAULT 'ToActivate',
  `msg_notify` enum('yes','no') NOT NULL DEFAULT 'yes',
  `avatar` varchar(225) NOT NULL DEFAULT '',
  `avatar_url` text NULL DEFAULT NULL,
  `sex` enum('male','female') NOT NULL DEFAULT 'male',
  `dob` date NOT NULL DEFAULT '1000-01-01',
  `country` varchar(20) NOT NULL DEFAULT 'PK',
  `level` int(6) NOT NULL DEFAULT 2,
  `avcode` mediumtext NOT NULL,
  `doj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_logged` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `num_visits` bigint(20) NOT NULL DEFAULT 0,
  `session` varchar(32) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `signup_ip` varchar(15) NOT NULL DEFAULT '',
  `time_zone` tinyint(4) NOT NULL DEFAULT 0,
  `featured` enum('no','yes') NOT NULL DEFAULT 'no',
  `featured_date` datetime DEFAULT NULL,
  `profile_hits` bigint(20) DEFAULT 0,
  `total_watched` bigint(20) NOT NULL DEFAULT 0,
  `total_videos` bigint(20) NOT NULL DEFAULT 0,
  `total_comments` bigint(20) NOT NULL DEFAULT 0,
  `total_photos` bigint(255) NOT NULL DEFAULT 0,
  `total_collections` bigint(255) NOT NULL DEFAULT 0,
  `comments_count` bigint(20) NOT NULL DEFAULT 0,
  `last_commented` datetime DEFAULT NULL,
  `voted` int(11) NOT NULL DEFAULT 0,
  `ban_status` enum('yes','no') NOT NULL DEFAULT 'no',
  `upload` varchar(20) NOT NULL DEFAULT '1',
  `subscribers` bigint(225) NOT NULL DEFAULT 0,
  `total_subscriptions` bigint(255) NOT NULL DEFAULT 0,
  `background` mediumtext DEFAULT NULL,
  `background_color` varchar(25) DEFAULT NULL,
  `background_url` text DEFAULT NULL,
  `background_repeat` enum('no-repeat','repeat','repeat-x','repeat-y') NOT NULL DEFAULT 'repeat',
  `last_active` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `banned_users` text DEFAULT NULL,
  `welcome_email_sent` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_downloads` bigint(255) NOT NULL DEFAULT 0,
  `album_privacy` enum('public','private','friends') NOT NULL DEFAULT 'private',
  `likes` int(11) NOT NULL DEFAULT 0,
  `is_live` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}user_levels` (
  `user_level_id` int(20) NOT NULL,
  `user_level_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `user_level_name` varchar(100) NOT NULL,
  `user_level_is_default` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}user_levels_permissions` (
  `user_level_permission_id` int(22) NOT NULL,
  `user_level_id` int(22) NOT NULL,
  `admin_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `allow_video_upload` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_photo_upload` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_video` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_photos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_collections` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_channel` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_videos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `avatar_upload` enum('yes','no') NOT NULL DEFAULT 'yes',
  `video_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `member_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `ad_manager_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `manage_template_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `group_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `web_config_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `view_channels` enum('yes','no') NOT NULL DEFAULT 'yes',
  `playlist_access` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_channel_bg` enum('yes','no') NOT NULL DEFAULT 'yes',
  `private_msg_access` enum('yes','no') NOT NULL DEFAULT 'yes',
  `edit_video` enum('yes','no') NOT NULL DEFAULT 'yes',
  `download_video` enum('yes','no') NOT NULL DEFAULT 'yes',
  `admin_del_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `photos_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `collection_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `plugins_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `tool_box` enum('yes','no') NOT NULL DEFAULT 'no',
  `plugins_perms` text NOT NULL,
  `allow_manage_user_level` enum('yes','no') NOT NULL DEFAULT 'no',
  `allow_create_collection` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_create_playlist` enum('yes','no') NOT NULL DEFAULT 'yes',
  `enable_channel_page` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}user_permissions` (
  `permission_id` int(225) NOT NULL,
  `permission_type` int(225) NOT NULL,
  `permission_name` varchar(225) NOT NULL,
  `permission_code` varchar(225) NOT NULL,
  `permission_desc` mediumtext NOT NULL,
  `permission_default` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}user_permission_types` (
  `user_permission_type_id` int(225) NOT NULL,
  `user_permission_type_name` varchar(225) NOT NULL,
  `user_permission_type_desc` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}user_profile` (
  `user_profile_id` int(11) NOT NULL,
  `show_my_collections` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` bigint(20) NOT NULL UNIQUE,
  `profile_title` mediumtext NOT NULL,
  `profile_desc` mediumtext NOT NULL,
  `featured_video` mediumtext NOT NULL,
  `first_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `show_dob` enum('no','yes') DEFAULT 'no',
  `postal_code` varchar(20) NOT NULL DEFAULT '',
  `time_zone` tinyint(4) NOT NULL DEFAULT 0,
  `web_url` varchar(200) NOT NULL DEFAULT '',
  `fb_url` varchar(200) DEFAULT '',
  `twitter_url` varchar(200) DEFAULT '',
  `insta_url` varchar(200) DEFAULT '',
  `hometown` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `online_status` enum('online','offline','custom') NOT NULL DEFAULT 'online',
  `show_profile` enum('all','members','friends') NOT NULL DEFAULT 'all',
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_ratings` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_subscription` enum('yes','no') NOT NULL DEFAULT 'yes',
  `content_filter` enum('Nothing','On','Off') NOT NULL DEFAULT 'Nothing',
  `icon_id` bigint(20) NOT NULL DEFAULT 0,
  `browse_criteria` mediumtext DEFAULT NULL,
  `about_me` mediumtext NOT NULL,
  `education` varchar(3) DEFAULT NULL,
  `schools` mediumtext NOT NULL,
  `occupation` mediumtext NOT NULL,
  `companies` mediumtext NOT NULL,
  `relation_status` varchar(15) DEFAULT NULL,
  `hobbies` mediumtext NOT NULL,
  `fav_movies` mediumtext NOT NULL,
  `fav_music` mediumtext NOT NULL,
  `fav_books` mediumtext NOT NULL,
  `background` mediumtext NOT NULL,
  `rating` tinyint(2) NOT NULL DEFAULT 0,
  `voters` text NOT NULL,
  `rated_by` int(150) NOT NULL DEFAULT 0,
  `show_my_videos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_photos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_subscriptions` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_subscribers` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_friends` enum('yes','no') NOT NULL DEFAULT 'yes',
  `disabled_channel` ENUM('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}video` (
  `videoid` bigint(20) NOT NULL,
  `videokey` mediumtext NOT NULL,
  `video_password` varchar(255) NOT NULL DEFAULT '',
  `video_users` text NULL DEFAULT NULL,
  `username` text NULL DEFAULT NULL,
  `userid` int(11) NULL DEFAULT NULL,
  `title` text DEFAULT NULL,
  `file_name` varchar(32) NOT NULL DEFAULT '',
  `file_type` VARCHAR(3) NULL DEFAULT NULL,
  `file_directory` varchar(25) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `broadcast` varchar(10) NOT NULL DEFAULT '',
  `location` mediumtext DEFAULT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `country` mediumtext DEFAULT NULL,
  `allow_embedding` char(3) NOT NULL DEFAULT '',
  `rating` int(15) NOT NULL DEFAULT 0,
  `rated_by` varchar(20) NOT NULL DEFAULT '0',
  `voter_ids` mediumtext NOT NULL,
  `allow_comments` char(3) NOT NULL DEFAULT '',
  `comment_voting` char(3) NOT NULL DEFAULT '',
  `comments_count` int(15) NOT NULL DEFAULT 0,
  `last_commented` datetime DEFAULT NULL,
  `featured` char(3) NOT NULL DEFAULT 'no',
  `featured_date` datetime DEFAULT NULL,
  `allow_rating` char(3) NOT NULL DEFAULT '',
  `active` char(3) NOT NULL DEFAULT '0',
  `favourite_count` varchar(15) NOT NULL DEFAULT '0',
  `playlist_count` varchar(15) NOT NULL DEFAULT '0',
  `views` bigint(22) NOT NULL DEFAULT 0,
  `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flagged` varchar(3) NOT NULL DEFAULT 'no',
  `duration` INT(20) NOT NULL DEFAULT 0,
  `status` enum('Successful','Processing','Failed','Waiting') NOT NULL DEFAULT 'Processing',
  `default_thumb` int(3) NOT NULL DEFAULT 1,
  `embed_code` text NULL DEFAULT NULL,
  `downloads` bigint(255) NOT NULL DEFAULT 0,
  `uploader_ip` varchar(20) NOT NULL DEFAULT '',
  `video_files` tinytext NULL DEFAULT NULL,
  `file_server_path` text NULL DEFAULT NULL,
  `video_version` varchar(8) NOT NULL DEFAULT '5.5.1',
  `thumbs_version` varchar(8) NOT NULL DEFAULT '5.5.1',
  `re_conv_status` tinytext NULL DEFAULT NULL,
  `is_castable` tinyint(1) NOT NULL DEFAULT 0,
  `bits_color` tinyint(4) DEFAULT NULL,
  `subscription_email` enum('pending','sent') NOT NULL DEFAULT 'pending',
  `age_restriction` INT DEFAULT NULL,
  `default_poster` int(3) NULL DEFAULT NULL,
  `default_backdrop` int(3) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}video_views` (
    `id_video_view` INT(11)  NOT NULL,
    `id_video`      BIGINT   NOT NULL,
    `id_user`       BIGINT   NOT NULL,
    `view_date`     DATETIME NOT NULL,
    PRIMARY KEY (`id_video_view`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}action_log`
  ADD PRIMARY KEY (`action_id`);

ALTER TABLE `{tbl_prefix}admin_notes`
  ADD PRIMARY KEY (`note_id`);

ALTER TABLE `{tbl_prefix}admin_todo`
  ADD PRIMARY KEY (`todo_id`);

ALTER TABLE `{tbl_prefix}ads_data`
  ADD PRIMARY KEY (`ad_id`);

ALTER TABLE `{tbl_prefix}ads_placements`
  ADD PRIMARY KEY (`placement_id`);

ALTER TABLE `{tbl_prefix}collections`
  ADD PRIMARY KEY (`collection_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `featured` (`featured`),
  ADD INDEX(`collection_id_parent`),
  ADD FULLTEXT KEY `collection_name` (`collection_name`);

ALTER TABLE `{tbl_prefix}collection_items`
  ADD PRIMARY KEY (`ci_id`);

ALTER TABLE `{tbl_prefix}comments`
  ADD PRIMARY KEY (`comment_id`);

ALTER TABLE `{tbl_prefix}config`
  ADD PRIMARY KEY (`configid`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `{tbl_prefix}contacts`
  ADD PRIMARY KEY (`contact_id`);

ALTER TABLE `{tbl_prefix}conversion_queue`
  ADD PRIMARY KEY (`cqueue_id`),
  ADD KEY `cqueue_conversion` (`cqueue_conversion`);

ALTER TABLE `{tbl_prefix}counters`
  ADD PRIMARY KEY (`counter_id`),
  ADD UNIQUE KEY `query_md5` (`query_md5`);

ALTER TABLE `{tbl_prefix}countries`
  ADD PRIMARY KEY (`country_id`);

ALTER TABLE `{tbl_prefix}email_templates`
  ADD PRIMARY KEY (`email_template_id`),
  ADD UNIQUE KEY `email_template_code` (`email_template_code`);

ALTER TABLE `{tbl_prefix}favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `userid` (`userid`);

ALTER TABLE `{tbl_prefix}flags`
  ADD PRIMARY KEY (`flag_id`);

ALTER TABLE `{tbl_prefix}languages`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `language_default` (`language_default`);

ALTER TABLE `{tbl_prefix}mass_emails`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `{tbl_prefix}messages`
  ADD PRIMARY KEY (`message_id`);

ALTER TABLE `{tbl_prefix}pages`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `active` (`active`,`display`);

ALTER TABLE `{tbl_prefix}photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `featured` (`featured`),
  ADD KEY `last_viewed` (`last_viewed`),
  ADD KEY `rating` (`rating`),
  ADD KEY `total_comments` (`total_comments`),
  ADD FULLTEXT KEY `photo_title` (`photo_title`);

ALTER TABLE `{tbl_prefix}playlists`
  ADD PRIMARY KEY (`playlist_id`),
  ADD FULLTEXT KEY `playlist_name` (`playlist_name`);

ALTER TABLE `{tbl_prefix}playlist_items`
  ADD PRIMARY KEY (`playlist_item_id`);

ALTER TABLE `{tbl_prefix}plugins`
  ADD PRIMARY KEY (`plugin_id`);

ALTER TABLE `{tbl_prefix}plugin_config`
  ADD PRIMARY KEY (`plugin_config_id`);

ALTER TABLE `{tbl_prefix}sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `session` (`session`);

ALTER TABLE `{tbl_prefix}stats`
  ADD PRIMARY KEY (`stat_id`);

ALTER TABLE `{tbl_prefix}subscriptions`
  ADD PRIMARY KEY (`subscription_id`);

ALTER TABLE `{tbl_prefix}template`
  ADD PRIMARY KEY (`template_id`);

ALTER TABLE `{tbl_prefix}users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `ind_status_doj` (`doj`),
  ADD KEY `ind_status_id` (`userid`),
  ADD KEY `ind_hits_doj` (`profile_hits`,`doj`),
  ADD KEY `username` (`username`(255),`userid`),
  ADD FULLTEXT KEY `username_fulltext` (`username`);

ALTER TABLE `{tbl_prefix}user_levels`
  ADD PRIMARY KEY (`user_level_id`);

ALTER TABLE `{tbl_prefix}user_levels_permissions`
  ADD PRIMARY KEY (`user_level_permission_id`),
  ADD KEY `user_level_id` (`user_level_id`);

ALTER TABLE `{tbl_prefix}user_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_code` (`permission_code`);

ALTER TABLE `{tbl_prefix}user_permission_types`
  ADD PRIMARY KEY (`user_permission_type_id`);

ALTER TABLE `{tbl_prefix}user_profile`
  ADD PRIMARY KEY (`user_profile_id`),
  ADD KEY `ind_status_id` (`userid`);

ALTER TABLE `{tbl_prefix}video`
  ADD PRIMARY KEY (`videoid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `featured` (`featured`),
  ADD KEY `last_viewed` (`last_viewed`),
  ADD KEY `rating` (`rating`),
  ADD KEY `comments_count` (`comments_count`),
  ADD KEY `status` (`status`,`active`,`broadcast`,`userid`),
  ADD KEY `videoid` (`videoid`,`videokey`(255)),
  ADD FULLTEXT KEY `description` (`description`,`title`);
ALTER TABLE `{tbl_prefix}video`
  ADD FULLTEXT KEY `title` (`title`);

ALTER TABLE `{tbl_prefix}action_log`
  MODIFY `action_id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}admin_notes`
  MODIFY `note_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}admin_todo`
  MODIFY `todo_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}ads_data`
  MODIFY `ad_id` int(50) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}ads_placements`
  MODIFY `placement_id` int(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}collections`
  MODIFY `collection_id` bigint(25) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}collection_items`
  MODIFY `ci_id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}comments`
  MODIFY `comment_id` int(60) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}config`
  MODIFY `configid` int(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}contacts`
  MODIFY `contact_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}conversion_queue`
  MODIFY `cqueue_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}counters`
  MODIFY `counter_id` int(100) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}countries`
  MODIFY `country_id` int(80) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}email_templates`
  MODIFY `email_template_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}favorites`
  MODIFY `favorite_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}flags`
  MODIFY `flag_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}languages`
  MODIFY `language_id` int(9) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}mass_emails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}messages`
  MODIFY `message_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}photos`
  MODIFY `photo_id` bigint(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}playlists`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}playlist_items`
  MODIFY `playlist_item_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}plugins`
  MODIFY `plugin_id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}plugin_config`
  MODIFY `plugin_config_id` int(223) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}stats`
  MODIFY `stat_id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}subscriptions`
  MODIFY `subscription_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}template`
  MODIFY `template_id` int(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}users`
  MODIFY `userid` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}user_levels`
  MODIFY `user_level_id` int(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}user_levels_permissions`
  MODIFY `user_level_permission_id` int(22) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}user_permissions`
  MODIFY `permission_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}user_permission_types`
  MODIFY `user_permission_type_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}user_profile`
  MODIFY `user_profile_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video`
  MODIFY `videoid` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video_views`
  MODIFY `id_video_view` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video_views`
    ADD CONSTRAINT `video_view_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}video_views`
    ADD CONSTRAINT `video_view_user` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `{tbl_prefix}video_resolution` (
	`id_video_resolution` int(11) NOT NULL,
	`title` varchar(32) NOT NULL DEFAULT '',
	`ratio` varchar(8) NOT NULL DEFAULT '',
	`enabled` tinyint(1) NOT NULL DEFAULT 1,
	`width` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`height` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`video_bitrate` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_resolution`
	ADD PRIMARY KEY (`id_video_resolution`),
	ADD UNIQUE KEY `title` (`title`);

ALTER TABLE `{tbl_prefix}video_resolution`
	MODIFY `id_video_resolution` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `{tbl_prefix}video_subtitle` (
	`videoid` bigint(20) NOT NULL,
	`number` varchar(2) NOT NULL,
	`title` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_subtitle`
	ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_subtitle`
	ADD CONSTRAINT `video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{tbl_prefix}collections`
	ADD FOREIGN KEY (`collection_id_parent`) REFERENCES `{tbl_prefix}collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `{tbl_prefix}languages_keys`(
    `id_language_key` INT          NOT NULL AUTO_INCREMENT,
    `language_key`    VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id_language_key`),
    UNIQUE (`language_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}languages_translations`(
    `language_id`     INT(11)      NOT NULL,
    `id_language_key` INT(11)      NOT NULL,
    `translation`     VARCHAR(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}languages_translations`
    ADD PRIMARY KEY (`language_id`, `id_language_key`),
    ADD KEY `language_id` (`language_id`),
    ADD KEY `id_language_key` (`id_language_key`);

ALTER TABLE `{tbl_prefix}languages_translations`
    ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `languages_translations_ibfk_2` FOREIGN KEY (`id_language_key`) REFERENCES `{tbl_prefix}languages_keys` (`id_language_key`) ON DELETE NO ACTION ON UPDATE NO ACTION;

CREATE TABLE `{tbl_prefix}video_thumbs`(
    `videoid`    BIGINT(20)  NOT NULL,
    `resolution` VARCHAR(16) NOT NULL,
    `num`        VARCHAR(4)  NOT NULL,
    `extension`  VARCHAR(4)  NOT NULL,
    `version`    VARCHAR(30) NOT NULL,
    `type`       VARCHAR(15) NOT NULL,
    PRIMARY KEY `resolution` (`videoid`, `resolution`, `num`),
    KEY `videoid` (`videoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_thumbs`
    ADD CONSTRAINT `video_thumbs_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION,
    ADD INDEX(`type`);

CREATE TABLE `{tbl_prefix}tools`(
    `id_tool`                  INT          NOT NULL AUTO_INCREMENT,
    `language_key_label`       VARCHAR(128) NOT NULL,
    `language_key_description` VARCHAR(128) NOT NULL,
    `function_name`            VARCHAR(128) NOT NULL,
    `code`                     VARCHAR(32)  NOT NULL UNIQUE,
    `frequency`                VARCHAR(30),
    `previous_calculated_datetime` datetime,
    `is_automatable`            BOOL DEFAULT TRUE,
    `is_disabled`               BOOL DEFAULT FALSE,
    PRIMARY KEY (`id_tool`),
    CONSTRAINT chk_frequency_previous_calculated_datetime_required CHECK (
        `frequency` IS NULL OR TRIM(`frequency`) = '' OR `previous_calculated_datetime` IS NOT NULL
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE `{tbl_prefix}tools_histo_status`(
    `id_tools_histo_status`    INT          NOT NULL AUTO_INCREMENT,
    `language_key_title` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id_tools_histo_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags`
(
    `id_tag`      INT          NOT NULL AUTO_INCREMENT,
    `id_tag_type` INT          NOT NULL,
    `name`        VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id_tag`),
    UNIQUE `id_tag_type` (`id_tag_type`, `name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;
ALTER TABLE `{tbl_prefix}tags` ADD FULLTEXT KEY `tag` (`name`);

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags_type`
(
    `id_tag_type` INT         NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id_tag_type`),
    UNIQUE `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tags`
    ADD CONSTRAINT `tag_type` FOREIGN KEY (`id_tag_type`) REFERENCES `{tbl_prefix}tags_type`(`id_tag_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tags`
(
    `id_video` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_video`, `id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_tags`
  ADD CONSTRAINT `video_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags`(`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `video_tags_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video`(`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;


CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_tags`
(
    `id_photo` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_photo`, `id_tag`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}photo_tags`
  ADD CONSTRAINT `photo_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `photo_tags_photo` FOREIGN KEY (`id_photo`) REFERENCES `{tbl_prefix}photos` (`photo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_tags`
(
    `id_collection` BIGINT NOT NULL,
    `id_tag`        INT    NOT NULL,
    PRIMARY KEY (`id_collection`, `id_tag`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}collection_tags`
  ADD CONSTRAINT `collection_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `collection_tags_collection` FOREIGN KEY (`id_collection`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}user_tags`
(
    `id_user` BIGINT NOT NULL,
    `id_tag`  INT    NOT NULL,
    PRIMARY KEY (`id_user`, `id_tag`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}user_tags`
  ADD CONSTRAINT `user_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_tags_user` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}playlist_tags`
(
    `id_playlist` INT NOT NULL,
    `id_tag`      INT NOT NULL,
    PRIMARY KEY (`id_playlist`, `id_tag`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}playlist_tags`
  ADD CONSTRAINT `playlist_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `playlist_tags_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `{tbl_prefix}playlists` (`playlist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}categories`
(
    `category_id`      INT(255)          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `parent_id`        INT(255)          NULL DEFAULT NULL,
    `id_category_type` INT(255)          NOT NULL,
    `category_name`    VARCHAR(30)       NOT NULL DEFAULT '',
    `category_order`   INT(5)            NOT NULL DEFAULT 0,
    `category_desc`    TEXT              NULL     DEFAULT NULL,
    `date_added`       DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `category_thumb`   MEDIUMTEXT        NULL,
    `is_default`        ENUM ('yes','no') NOT NULL DEFAULT 'no'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;
ALTER TABLE `{tbl_prefix}categories`
    ADD CONSTRAINT `categorie_parent` FOREIGN KEY (`parent_id`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `{tbl_prefix}categories` ADD FULLTEXT KEY `categorie` (`category_name`);

CREATE TABLE IF NOT EXISTS `{tbl_prefix}categories_type`
(
    `id_category_type` INT         NOT NULL AUTO_INCREMENT,
    `name`             VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id_category_type`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}categories`
    ADD CONSTRAINT `categorie_type` FOREIGN KEY (`id_category_type`) REFERENCES `{tbl_prefix}categories_type` (`id_category_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}videos_categories`
(
    `id_video`    BIGINT NOT NULL,
    `id_category` INT    NOT NULL,
    PRIMARY KEY (`id_video`, `id_category`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}videos_categories`
    ADD CONSTRAINT `video_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}videos_categories`
    ADD CONSTRAINT `video_categories_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}photos_categories`
(
    `id_photo`    BIGINT NOT NULL,
    `id_category` INT    NOT NULL,
    PRIMARY KEY (`id_photo`, `id_category`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}photos_categories`
    ADD CONSTRAINT `photo_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}photos_categories`
    ADD CONSTRAINT `photo_categories_photo` FOREIGN KEY (`id_photo`) REFERENCES `{tbl_prefix}photos` (`photo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}collections_categories`
(
    `id_collection` BIGINT NOT NULL,
    `id_category`   INT    NOT NULL,
    PRIMARY KEY (`id_collection`, `id_category`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}collections_categories`
    ADD CONSTRAINT `collection_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}collections_categories`
    ADD CONSTRAINT `collection_categories_collection` FOREIGN KEY (`id_collection`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}users_categories`
(
    `id_user`     BIGINT NOT NULL,
    `id_category` INT    NOT NULL,
    PRIMARY KEY (`id_user`, `id_category`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}users_categories`
    ADD CONSTRAINT `user_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}users_categories`
    ADD CONSTRAINT `user_categories_profile` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}playlists_categories`
(
    `id_playlist` INT NOT NULL,
    `id_category` INT NOT NULL,
    PRIMARY KEY (`id_playlist`, `id_category`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}playlists_categories`
    ADD CONSTRAINT `playlist_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}playlists_categories`
    ADD CONSTRAINT `playlist_categories_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `{tbl_prefix}playlists` (`playlist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_histo`
(
    `id_histo`              INT      NOT NULL AUTO_INCREMENT,
    `id_tool`               INT      NOT NULL,
    `id_tools_histo_status` INT      NOT NULL,
    `date_start`            DATETIME NOT NULL,
    `date_end`              DATETIME NULL,
    `elements_total`        INT      NULL,
    `elements_done`         INT      NULL,
    PRIMARY KEY (`id_histo`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tools_histo`
    ADD CONSTRAINT `id_tools_histo` FOREIGN KEY (`id_tool`) REFERENCES `{tbl_prefix}tools` (`id_tool`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `id_tools_histo_status` FOREIGN KEY (`id_tools_histo_status`) REFERENCES `{tbl_prefix}tools_histo_status` (`id_tools_histo_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_histo_log`
(
    `id_log`   INT          NOT NULL AUTO_INCREMENT,
    `id_histo` INT          NOT NULL,
    `datetime` DATETIME     NOT NULL,
    `message`  VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id_log`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tools_histo_log`
    ADD CONSTRAINT `id_tools_histo_log` FOREIGN KEY (`id_histo`) REFERENCES `{tbl_prefix}tools_histo` (`id_histo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tmdb_search`
(
    `id_tmdb_search`  INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `search_key`      VARCHAR(128) NOT NULL UNIQUE,
    `datetime_search` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total_results`   INT          NOT NULL,
    `list_years`      TEXT         NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tmdb_search_result`
(
    `id_tmdb_search_result` INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_tmdb_search`        INT          NOT NULL,
    `title`                 VARCHAR(256) NOT NULL,
    `overview`              TEXT         NULL,
    `poster_path`           VARCHAR(128) NOT NULL,
    `release_date`          DATE         NULL,
    `id_tmdb_movie`         INT          NOT NULL,
    `is_adult`              BOOLEAN      NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;
ALTER TABLE `{tbl_prefix}tmdb_search_result`
    ADD CONSTRAINT `search_result` FOREIGN KEY (`id_tmdb_search`) REFERENCES `{tbl_prefix}tmdb_search` (`id_tmdb_search`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}timezones` (
   `id` INT AUTO_INCREMENT PRIMARY KEY,
   `timezone` VARCHAR(255) NOT NULL UNIQUE
) ENGINE = InnoDB
DEFAULT CHARSET = utf8mb4
COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}users_storage_histo`
(
    `id_user`       BIGINT   NOT NULL,
    `datetime`      DATETIME NOT NULL DEFAULT NOW(),
    `storage_used`  BIGINT   NOT NULL,
    PRIMARY KEY (`id_user`, `datetime`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;
ALTER TABLE `{tbl_prefix}users_storage_histo`
    ADD CONSTRAINT `id_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `{tbl_prefix}fontawesome_icons` (
    `id_fontawesome_icon` int(11) NOT NULL,
    `icon` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
ALTER TABLE `{tbl_prefix}fontawesome_icons`
    ADD PRIMARY KEY (`id_fontawesome_icon`),
    ADD UNIQUE KEY `icon` (`icon`);
ALTER TABLE `{tbl_prefix}fontawesome_icons`
    MODIFY `id_fontawesome_icon` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `{tbl_prefix}social_networks_links` (
    `id_social_networks_link` int(11) NOT NULL,
    `id_fontawesome_icon` int(11) NOT NULL,
    `title` varchar(64) NOT NULL,
    `url` varchar(256) NOT NULL,
    `social_network_link_order` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
ALTER TABLE `{tbl_prefix}social_networks_links`
    ADD PRIMARY KEY (`id_social_networks_link`),
    ADD KEY `id_fontawesome_icon` (`id_fontawesome_icon`);
ALTER TABLE `{tbl_prefix}social_networks_links`
    MODIFY `id_social_networks_link` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `{tbl_prefix}social_networks_links`
    ADD CONSTRAINT `social_networks_links_ibfk_1` FOREIGN KEY (`id_fontawesome_icon`) REFERENCES `{tbl_prefix}fontawesome_icons` (`id_fontawesome_icon`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{tbl_prefix}sessions`
    ADD INDEX(`session_date`);
