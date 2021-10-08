CREATE TABLE `{tbl_prefix}action_log` (
  `action_id` int(255) NOT NULL,
  `action_type` varchar(60) NOT NULL,
  `action_username` varchar(60) NOT NULL,
  `action_userid` int(30) NOT NULL,
  `action_useremail` varchar(200) NOT NULL,
  `action_userlevel` int(11) NOT NULL,
  `action_ip` varchar(15) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action_success` enum('yes','no') DEFAULT NULL,
  `action_details` text NOT NULL,
  `action_obj_id` int(255) NOT NULL,
  `action_done_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}admin_notes` (
  `note_id` int(225) NOT NULL,
  `note` text CHARACTER SET ucs2 NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}admin_todo` (
  `todo_id` int(225) NOT NULL,
  `todo` text CHARACTER SET ucs2 NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `{tbl_prefix}ads_data` (
  `ad_id` int(50) NOT NULL,
  `ad_name` mediumtext NOT NULL,
  `ad_code` mediumtext NOT NULL,
  `ad_placement` varchar(50) NOT NULL DEFAULT '',
  `ad_status` enum('0','1') NOT NULL DEFAULT '0',
  `ad_impressions` bigint(255) NOT NULL DEFAULT 0,
  `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}ads_placements` (
  `placement_id` int(20) NOT NULL,
  `placement` varchar(26) NOT NULL,
  `placement_name` varchar(50) NOT NULL,
  `disable` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}collections` (
  `collection_id` bigint(25) NOT NULL,
  `collection_name` varchar(225) NOT NULL,
  `collection_description` text NOT NULL,
  `collection_tags` text NOT NULL,
  `category` varchar(200) NOT NULL,
  `userid` int(10) NOT NULL,
  `views` bigint(20) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `featured` varchar(4) NOT NULL DEFAULT 'no',
  `broadcast` varchar(10) NOT NULL,
  `allow_comments` varchar(4) NOT NULL,
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` bigint(20) NOT NULL DEFAULT 0,
  `last_commented` datetime DEFAULT NULL,
  `total_objects` bigint(20) NOT NULL DEFAULT 0,
  `rating` bigint(20) NOT NULL DEFAULT 0,
  `rated_by` bigint(20) NOT NULL DEFAULT 0,
  `voters` longtext DEFAULT NULL,
  `active` varchar(4) NOT NULL,
  `public_upload` varchar(4) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}collection_categories` (
  `category_id` int(255) NOT NULL,
  `parent_id` int(255) NOT NULL DEFAULT 1,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 0,
  `category_desc` text NULL DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_thumb` mediumint(9) NOT NULL DEFAULT 0,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}collection_contributors` (
  `contributor_id` int(200) NOT NULL,
  `collection_id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `can_edit` enum('yes','no') NOT NULL DEFAULT 'no',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `{tbl_prefix}collection_items` (
  `ci_id` bigint(20) NOT NULL,
  `collection_id` bigint(20) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}comments` (
  `comment_id` int(60) NOT NULL,
  `type` varchar(3) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}config` (
  `configid` int(20) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}contacts` (
  `contact_id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `contact_userid` int(225) NOT NULL,
  `confirmed` enum('yes','no') NOT NULL DEFAULT 'no',
  `contact_group_id` int(255) NOT NULL DEFAULT 0,
  `request_type` enum('in','out') NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}conversion_queue` (
  `cqueue_id` int(11) NOT NULL,
  `cqueue_name` varchar(32) NOT NULL,
  `cqueue_ext` varchar(5) NOT NULL,
  `cqueue_tmp_ext` varchar(3) NOT NULL,
  `cqueue_conversion` enum('yes','no','p') NOT NULL DEFAULT 'no',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_started` varchar(32) NOT NULL DEFAULT '0',
  `time_completed` varchar(32) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}counters` (
  `counter_id` int(100) NOT NULL,
  `section` varchar(200) NOT NULL,
  `query` text NOT NULL,
  `query_md5` varchar(200) NOT NULL,
  `counts` bigint(200) NOT NULL,
  `date_added` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `{tbl_prefix}countries` (
  `country_id` int(80) NOT NULL,
  `iso2` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `name_en` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}email_templates` (
  `email_template_id` int(11) NOT NULL,
  `email_template_name` varchar(225) NOT NULL,
  `email_template_code` varchar(225) NOT NULL,
  `email_template_subject` mediumtext NOT NULL,
  `email_template` text NOT NULL,
  `email_template_allowed_tags` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}favorites` (
  `favorite_id` int(225) NOT NULL,
  `type` varchar(4) NOT NULL,
  `id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}flags` (
  `flag_id` int(225) NOT NULL,
  `type` varchar(4) NOT NULL,
  `id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `flag_type` bigint(25) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}groups` (
  `group_id` int(225) NOT NULL,
  `group_name` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(255) NOT NULL,
  `group_admins` text NOT NULL,
  `group_description` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group_tags` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group_url` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group_privacy` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `video_type` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `post_type` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `date_added` datetime NOT NULL,
  `featured` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `total_views` bigint(225) NOT NULL,
  `total_videos` int(225) NOT NULL,
  `total_members` int(225) NOT NULL,
  `total_topics` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}group_categories` (
  `category_id` int(225) NOT NULL,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 1,
  `category_desc` text NOT NULL,
  `date_added` datetime NOT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}group_invitations` (
  `invitation_id` int(225) NOT NULL,
  `group_id` int(225) NOT NULL,
  `userid` int(255) NOT NULL,
  `invited` int(225) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}group_members` (
  `group_mid` int(225) NOT NULL,
  `group_id` int(225) NOT NULL,
  `userid` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}group_posts` (
  `post_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_content` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}group_topics` (
  `topic_id` int(225) NOT NULL,
  `topic_title` text NOT NULL,
  `userid` int(225) NOT NULL,
  `group_id` int(225) NOT NULL,
  `topic_post` text NOT NULL,
  `date_added` datetime NOT NULL,
  `last_poster` int(225) NOT NULL,
  `last_post_time` datetime NOT NULL,
  `total_views` bigint(225) NOT NULL,
  `total_replies` bigint(225) NOT NULL,
  `topic_icon` varchar(225) NOT NULL,
  `approved` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}group_videos` (
  `group_video_id` int(225) NOT NULL,
  `videoid` int(255) NOT NULL,
  `group_id` int(225) NOT NULL,
  `userid` int(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approved` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}languages` (
  `language_id` int(9) NOT NULL,
  `language_code` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `language_regex` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `language_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `language_default` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}photos` (
  `photo_id` bigint(255) NOT NULL,
  `photo_key` mediumtext NOT NULL,
  `photo_title` mediumtext NOT NULL,
  `photo_description` mediumtext NOT NULL,
  `photo_tags` mediumtext NOT NULL,
  `userid` int(255) NOT NULL,
  `collection_id` int(255) NOT NULL,
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
  `photo_details` text NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}phrases` (
  `id` int(10) UNSIGNED NOT NULL,
  `lang_iso` varchar(5) NOT NULL DEFAULT 'en',
  `varname` varchar(250) NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}playlists` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(225) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT 0,
  `playlist_type` varchar(10) NOT NULL DEFAULT '',
  `category` enum('normal','favorites','likes','history','quicklist','watch_later') NOT NULL DEFAULT 'normal',
  `description` mediumtext NOT NULL,
  `tags` mediumtext NOT NULL,
  `privacy` enum('public','private','unlisted') NOT NULL DEFAULT 'public',
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` int(255) NOT NULL DEFAULT 0,
  `total_items` int(255) NOT NULL DEFAULT 0,
  `rating` int(3) NOT NULL DEFAULT 0,
  `rated_by` int(255) NOT NULL DEFAULT 0,
  `voters` text NULL DEFAULT NULL,
  `last_update` text NULL DEFAULT NULL,
  `runtime` int(200) NOT NULL DEFAULT 0,
  `first_item` text NULL DEFAULT NULL,
  `cover` text NULL DEFAULT NULL,
  `played` int(255) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}playlist_items` (
  `playlist_item_id` int(225) NOT NULL,
  `object_id` int(225) NOT NULL,
  `playlist_id` int(225) NOT NULL,
  `playlist_item_type` varchar(10) NOT NULL,
  `userid` int(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}plugins` (
  `plugin_id` int(255) NOT NULL,
  `plugin_file` text NOT NULL,
  `plugin_folder` text NOT NULL,
  `plugin_version` varchar(32) NOT NULL,
  `plugin_license_type` varchar(10) NOT NULL DEFAULT 'GPL',
  `plugin_license_key` varchar(5) NOT NULL,
  `plugin_license_code` text NOT NULL,
  `plugin_active` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}plugin_config` (
  `plugin_config_id` int(223) NOT NULL,
  `plugin_id_code` varchar(25) NOT NULL,
  `plugin_config_name` text NOT NULL,
  `plugin_config_value` text NOT NULL,
  `player_type` enum('built-in','plugin') NOT NULL DEFAULT 'built-in',
  `player_admin_file` text NOT NULL,
  `player_include_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}stats` (
  `stat_id` int(255) NOT NULL,
  `date_added` date NOT NULL,
  `video_stats` text NOT NULL,
  `user_stats` text NOT NULL,
  `group_stats` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}subscriptions` (
  `subscription_id` int(225) NOT NULL,
  `userid` int(11) NOT NULL,
  `subscribed_to` mediumtext NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}template` (
  `template_id` int(20) NOT NULL,
  `template_name` varchar(25) NOT NULL,
  `template_dir` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}users` (
  `userid` bigint(20) NOT NULL,
  `category` int(20) NOT NULL DEFAULT 0,
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
  `featured` enum('No','Yes') NOT NULL DEFAULT 'No',
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
  `total_groups` bigint(20) NOT NULL DEFAULT 0,
  `last_active` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `banned_users` text DEFAULT NULL,
  `welcome_email_sent` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_downloads` bigint(255) NOT NULL DEFAULT 0,
  `album_privacy` enum('public','private','friends') NOT NULL DEFAULT 'private',
  `likes` int(11) NOT NULL DEFAULT 0,
  `is_live` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}user_categories` (
  `category_id` int(225) NOT NULL,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 1,
  `category_desc` text NOT NULL,
  `date_added` datetime NOT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}user_levels` (
  `user_level_id` int(20) NOT NULL,
  `user_level_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `user_level_name` varchar(100) NOT NULL,
  `user_level_is_default` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}user_levels_permissions` (
  `user_level_permission_id` int(22) NOT NULL,
  `user_level_id` int(22) NOT NULL,
  `admin_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `allow_video_upload` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_video` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_photos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_collections` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_channel` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_group` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_videos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `avatar_upload` enum('yes','no') NOT NULL DEFAULT 'yes',
  `video_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `member_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `ad_manager_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `manage_template_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `group_moderation` enum('yes','no') NOT NULL DEFAULT 'no',
  `web_config_access` enum('yes','no') NOT NULL DEFAULT 'no',
  `view_channels` enum('yes','no') NOT NULL DEFAULT 'yes',
  `view_groups` enum('yes','no') NOT NULL DEFAULT 'yes',
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
  `allow_create_playlist` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}user_permissions` (
  `permission_id` int(225) NOT NULL,
  `permission_type` int(225) NOT NULL,
  `permission_name` varchar(225) NOT NULL,
  `permission_code` varchar(225) NOT NULL,
  `permission_desc` mediumtext NOT NULL,
  `permission_default` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}user_permission_types` (
  `user_permission_type_id` int(225) NOT NULL,
  `user_permission_type_name` varchar(225) NOT NULL,
  `user_permission_type_desc` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}user_profile` (
  `user_profile_id` int(11) NOT NULL,
  `show_my_collections` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` bigint(20) NOT NULL,
  `profile_title` mediumtext NOT NULL,
  `profile_desc` mediumtext NOT NULL,
  `featured_video` mediumtext NOT NULL,
  `first_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `avatar` varchar(225) NOT NULL DEFAULT 'no_avatar.png',
  `show_dob` enum('no','yes') DEFAULT 'no',
  `postal_code` varchar(20) NOT NULL DEFAULT '',
  `time_zone` tinyint(4) NOT NULL DEFAULT 0,
  `profile_tags` mediumtext DEFAULT NULL,
  `web_url` varchar(200) NOT NULL DEFAULT '',
  `fb_url` varchar(200) DEFAULT '',
  `twitter_url` varchar(200) DEFAULT '',
  `insta_url` varchar(200) DEFAULT '',
  `hometown` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `online_status` enum('online','offline','custom') NOT NULL DEFAULT 'online',
  `show_profile` enum('all','members','friends') NOT NULL DEFAULT 'all',
  `allow_comments` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `allow_ratings` enum('Yes','No') NOT NULL DEFAULT 'Yes',
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
  `profile_video` int(255) NOT NULL,
  `profile_item` varchar(25) NOT NULL,
  `rating` tinyint(2) NOT NULL,
  `voters` text NOT NULL,
  `rated_by` int(150) NOT NULL,
  `show_my_videos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_photos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_subscriptions` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_subscribers` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_friends` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}validation_re` (
  `re_id` int(25) NOT NULL,
  `re_name` varchar(60) NOT NULL,
  `re_code` varchar(60) NOT NULL,
  `re_syntax` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}video` (
  `videoid` bigint(20) NOT NULL,
  `videokey` mediumtext NOT NULL,
  `video_password` varchar(255) NOT NULL,
  `video_users` text NOT NULL,
  `username` text NULL DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `file_name` varchar(32) NOT NULL,
  `file_type` int(10) NOT NULL DEFAULT 0,
  `file_directory` varchar(25) NOT NULL,
  `description` text DEFAULT NULL,
  `tags` mediumtext NOT NULL,
  `category` varchar(200) NOT NULL DEFAULT '0',
  `category_parents` text NULL DEFAULT NULL,
  `broadcast` varchar(10) NOT NULL DEFAULT '',
  `location` mediumtext DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  `country` mediumtext DEFAULT NULL,
  `blocked_countries` text NULL DEFAULT NULL,
  `sprite_count` int(11) NOT NULL DEFAULT 0,
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
  `featured_description` mediumtext NOT NULL,
  `allow_rating` char(3) NOT NULL DEFAULT '',
  `active` char(3) NOT NULL DEFAULT '0',
  `favourite_count` varchar(15) NOT NULL DEFAULT '0',
  `playlist_count` varchar(15) NOT NULL DEFAULT '0',
  `views` bigint(22) NOT NULL DEFAULT 0,
  `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flagged` varchar(3) NOT NULL DEFAULT 'no',
  `duration` varchar(20) NOT NULL DEFAULT '00',
  `status` enum('Successful','Processing','Failed') NOT NULL DEFAULT 'Processing',
  `failed_reason` enum('none','max_duration','max_file','invalid_format','invalid_upload') NOT NULL DEFAULT 'none',
  `default_thumb` int(3) NOT NULL DEFAULT 1,
  `aspect_ratio` varchar(10) NOT NULL DEFAULT '',
  `embed_code` text NULL DEFAULT NULL,
  `refer_url` text NULL DEFAULT NULL,
  `downloads` bigint(255) NOT NULL DEFAULT 0,
  `uploader_ip` varchar(20) NOT NULL,
  `mass_embed_status` enum('no','pending','approved') NOT NULL DEFAULT 'no',
  `is_hd` enum('yes','no') NOT NULL DEFAULT 'no',
  `unique_embed_code` varchar(50) NOT NULL DEFAULT '',
  `remote_play_url` text NULL DEFAULT NULL,
  `video_files` tinytext NULL DEFAULT NULL,
  `server_ip` varchar(20) NOT NULL DEFAULT '',
  `file_server_path` text NULL DEFAULT NULL,
  `files_thumbs_path` text NULL DEFAULT NULL,
  `file_thumbs_count` varchar(30) NOT NULL DEFAULT '',
  `has_hq` enum('yes','no') NOT NULL DEFAULT 'no',
  `has_mobile` enum('yes','no') NOT NULL DEFAULT 'no',
  `filegrp_size` varchar(30) NOT NULL DEFAULT '',
  `process_status` bigint(30) NOT NULL DEFAULT 0,
  `has_hd` enum('yes','no') NOT NULL DEFAULT 'no',
  `video_version` varchar(30) NOT NULL DEFAULT '5.4.1',
  `extras` varchar(225) NOT NULL DEFAULT '',
  `thumbs_version` varchar(5) NOT NULL DEFAULT '5.4.1',
  `re_conv_status` tinytext NULL DEFAULT NULL,
  `conv_progress` text NULL DEFAULT NULL,
  `is_castable` tinyint(1) NOT NULL DEFAULT 0,
  `bits_color` tinyint(4) DEFAULT NULL,
  `subscription_email` enum('pending','sent') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}video_categories` (
  `category_id` int(225) NOT NULL,
  `parent_id` int(255) NOT NULL DEFAULT 0,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 1,
  `category_desc` text NULL DEFAULT NULL,
  `date_added` datetime NULL DEFAULT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}video_favourites` (
  `fav_id` int(11) NOT NULL,
  `videoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}video_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(2) NOT NULL,
  `file_conversion_log` text NOT NULL,
  `encoder` char(16) NOT NULL,
  `command_used` text NOT NULL,
  `src_path` text NOT NULL,
  `src_name` char(64) NOT NULL,
  `src_ext` char(8) NOT NULL,
  `src_format` char(32) NOT NULL,
  `src_duration` char(10) NOT NULL,
  `src_size` char(10) NOT NULL,
  `src_bitrate` char(6) NOT NULL,
  `src_video_width` char(5) NOT NULL,
  `src_video_height` char(5) NOT NULL,
  `src_video_wh_ratio` char(10) NOT NULL,
  `src_video_codec` char(16) NOT NULL,
  `src_video_rate` char(10) NOT NULL,
  `src_video_bitrate` char(10) NOT NULL,
  `src_video_color` char(16) NOT NULL,
  `src_audio_codec` char(16) NOT NULL,
  `src_audio_bitrate` char(10) NOT NULL,
  `src_audio_rate` char(10) NOT NULL,
  `src_audio_channels` char(16) NOT NULL,
  `output_path` text NOT NULL,
  `output_format` char(32) NOT NULL,
  `output_duration` char(10) NOT NULL,
  `output_size` char(10) NOT NULL,
  `output_bitrate` char(6) NOT NULL,
  `output_video_width` char(5) NOT NULL,
  `output_video_height` char(5) NOT NULL,
  `output_video_wh_ratio` char(10) NOT NULL,
  `output_video_codec` char(16) NOT NULL,
  `output_video_rate` char(10) NOT NULL,
  `output_video_bitrate` char(10) NOT NULL,
  `output_video_color` char(16) NOT NULL,
  `output_audio_codec` char(16) NOT NULL,
  `output_audio_bitrate` char(10) NOT NULL,
  `output_audio_rate` char(10) NOT NULL,
  `output_audio_channels` char(16) NOT NULL,
  `hd` enum('yes','no') NOT NULL DEFAULT 'no',
  `hq` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{tbl_prefix}video_views` (
  `id` int(11) NOT NULL,
  `video_id` varchar(255) NOT NULL,
  `video_views` int(11) NOT NULL,
  `last_updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  ADD KEY `userid_2` (`userid`),
  ADD KEY `featured_2` (`featured`);

ALTER TABLE `{tbl_prefix}collection_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `{tbl_prefix}collection_contributors`
  ADD PRIMARY KEY (`contributor_id`);

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
  ADD KEY `cqueue_conversion` (`cqueue_conversion`),
  ADD KEY `cqueue_conversion_2` (`cqueue_conversion`);

ALTER TABLE `{tbl_prefix}counters`
  ADD PRIMARY KEY (`counter_id`),
  ADD UNIQUE KEY `query_md5` (`query_md5`);

ALTER TABLE `{tbl_prefix}countries`
  ADD PRIMARY KEY (`country_id`);

ALTER TABLE `{tbl_prefix}editors_picks`
  ADD PRIMARY KEY (`pick_id`),
  ADD KEY `videoid` (`videoid`),
  ADD KEY `videoid_2` (`videoid`);

ALTER TABLE `{tbl_prefix}email_templates`
  ADD PRIMARY KEY (`email_template_id`),
  ADD UNIQUE KEY `email_template_code` (`email_template_code`);

ALTER TABLE `{tbl_prefix}favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `userid_2` (`userid`);

ALTER TABLE `{tbl_prefix}flags`
  ADD PRIMARY KEY (`flag_id`);

ALTER TABLE `{tbl_prefix}groups`
  ADD PRIMARY KEY (`group_id`);

ALTER TABLE `{tbl_prefix}group_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `{tbl_prefix}group_invitations`
  ADD PRIMARY KEY (`invitation_id`);

ALTER TABLE `{tbl_prefix}group_members`
  ADD PRIMARY KEY (`group_mid`);

ALTER TABLE `{tbl_prefix}group_posts`
  ADD PRIMARY KEY (`post_id`);

ALTER TABLE `{tbl_prefix}group_topics`
  ADD PRIMARY KEY (`topic_id`);

ALTER TABLE `{tbl_prefix}group_videos`
  ADD PRIMARY KEY (`group_video_id`);

ALTER TABLE `{tbl_prefix}languages`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `language_default` (`language_default`),
  ADD KEY `language_code` (`language_code`,`language_id`),
  ADD KEY `language_default_2` (`language_default`),
  ADD KEY `language_code_2` (`language_code`,`language_id`);

ALTER TABLE `{tbl_prefix}mass_emails`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `{tbl_prefix}messages`
  ADD PRIMARY KEY (`message_id`);

ALTER TABLE `{tbl_prefix}pages`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `active` (`active`,`display`),
  ADD KEY `active_2` (`active`,`display`);

ALTER TABLE `{tbl_prefix}photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `collection_id` (`collection_id`),
  ADD KEY `featured` (`featured`),
  ADD KEY `last_viewed` (`last_viewed`),
  ADD KEY `rating` (`rating`),
  ADD KEY `total_comments` (`total_comments`),
  ADD KEY `last_viewed_2` (`last_viewed`),
  ADD KEY `userid_2` (`userid`),
  ADD KEY `collection_id_2` (`collection_id`),
  ADD KEY `featured_2` (`featured`),
  ADD KEY `last_viewed_3` (`last_viewed`),
  ADD KEY `rating_2` (`rating`),
  ADD KEY `total_comments_2` (`total_comments`),
  ADD KEY `last_viewed_4` (`last_viewed`);
ALTER TABLE `{tbl_prefix}photos` ADD FULLTEXT KEY `photo_title` (`photo_title`,`photo_tags`);

ALTER TABLE `{tbl_prefix}phrases`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `{tbl_prefix}playlists`
  ADD PRIMARY KEY (`playlist_id`);

ALTER TABLE `{tbl_prefix}playlist_items`
  ADD PRIMARY KEY (`playlist_item_id`);

ALTER TABLE `{tbl_prefix}plugins`
  ADD PRIMARY KEY (`plugin_id`);

ALTER TABLE `{tbl_prefix}plugin_config`
  ADD PRIMARY KEY (`plugin_config_id`);

ALTER TABLE `{tbl_prefix}sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `session` (`session`),
  ADD KEY `session_2` (`session`);

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
  ADD KEY `username_2` (`username`(255),`userid`);

ALTER TABLE `{tbl_prefix}user_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `{tbl_prefix}user_levels`
  ADD PRIMARY KEY (`user_level_id`);

ALTER TABLE `{tbl_prefix}user_levels_permissions`
  ADD PRIMARY KEY (`user_level_permission_id`),
  ADD KEY `user_level_id` (`user_level_id`),
  ADD KEY `user_level_id_2` (`user_level_id`);

ALTER TABLE `{tbl_prefix}user_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_code` (`permission_code`);

ALTER TABLE `{tbl_prefix}user_permission_types`
  ADD PRIMARY KEY (`user_permission_type_id`);

ALTER TABLE `{tbl_prefix}user_profile`
  ADD PRIMARY KEY (`user_profile_id`),
  ADD KEY `ind_status_id` (`userid`);
ALTER TABLE `{tbl_prefix}user_profile` ADD FULLTEXT KEY `profile_tags` (`profile_tags`);

ALTER TABLE `{tbl_prefix}validation_re`
  ADD PRIMARY KEY (`re_id`);

ALTER TABLE `{tbl_prefix}video`
  ADD PRIMARY KEY (`videoid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `featured` (`featured`),
  ADD KEY `last_viewed` (`last_viewed`),
  ADD KEY `rating` (`rating`),
  ADD KEY `comments_count` (`comments_count`),
  ADD KEY `last_viewed_2` (`last_viewed`),
  ADD KEY `status` (`status`,`active`,`broadcast`,`userid`),
  ADD KEY `userid_2` (`userid`),
  ADD KEY `videoid` (`videoid`,`videokey`(255)),
  ADD KEY `userid_3` (`userid`),
  ADD KEY `featured_2` (`featured`),
  ADD KEY `last_viewed_3` (`last_viewed`),
  ADD KEY `rating_2` (`rating`),
  ADD KEY `comments_count_2` (`comments_count`),
  ADD KEY `last_viewed_4` (`last_viewed`),
  ADD KEY `status_2` (`status`,`active`,`broadcast`,`userid`),
  ADD KEY `userid_4` (`userid`),
  ADD KEY `videoid_2` (`videoid`,`videokey`(255));
ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT KEY `description` (`description`,`title`);
ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT KEY `title` (`title`,`tags`);

ALTER TABLE `{tbl_prefix}video_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `{tbl_prefix}video_favourites`
  ADD PRIMARY KEY (`fav_id`);

ALTER TABLE `{tbl_prefix}video_files`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `{tbl_prefix}video_files` ADD FULLTEXT KEY `src_bitrate` (`src_bitrate`);

ALTER TABLE `{tbl_prefix}video_views`
  ADD PRIMARY KEY (`id`);

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

ALTER TABLE `{tbl_prefix}collection_categories`
  MODIFY `category_id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}collection_contributors`
  MODIFY `contributor_id` int(200) NOT NULL AUTO_INCREMENT;

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

ALTER TABLE `{tbl_prefix}groups`
  MODIFY `group_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}group_categories`
  MODIFY `category_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}group_invitations`
  MODIFY `invitation_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}group_members`
  MODIFY `group_mid` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}group_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}group_topics`
  MODIFY `topic_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}group_videos`
  MODIFY `group_video_id` int(225) NOT NULL AUTO_INCREMENT;

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

ALTER TABLE `{tbl_prefix}phrases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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

ALTER TABLE `{tbl_prefix}user_categories`
  MODIFY `category_id` int(225) NOT NULL AUTO_INCREMENT;

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

ALTER TABLE `{tbl_prefix}validation_re`
  MODIFY `re_id` int(25) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video`
  MODIFY `videoid` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video_categories`
  MODIFY `category_id` int(225) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video_favourites`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `{tbl_prefix}video_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
