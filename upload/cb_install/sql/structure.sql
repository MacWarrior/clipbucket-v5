--
-- Table structure for table `action_log`
--

CREATE TABLE `{tbl_prefix}action_log` (
  `action_id` int(255) NOT NULL AUTO_INCREMENT,
  `action_type` varchar(60) NOT NULL,
  `action_username` varchar(60) NOT NULL,
  `action_userid` int(30) NOT NULL,
  `action_useremail` varchar(200) NOT NULL,
  `action_userlevel` int(11) NOT NULL,
  `action_ip` varchar(15) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action_success` enum('yes','no') NULL DEFAULT NULL,
  `action_details` text NOT NULL,
  `action_obj_id` int(255) NOT NULL,
  `action_done_id` int(255) NOT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- Table structure for table `admin_notes`
--

CREATE TABLE `{tbl_prefix}admin_notes` (
  `note_id` int(225) NOT NULL AUTO_INCREMENT,
  `note` text CHARACTER SET ucs2 NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(225) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `admin_todo`
--

CREATE TABLE `{tbl_prefix}admin_todo` (
  `todo_id` int(225) NOT NULL AUTO_INCREMENT,
  `todo` text CHARACTER SET ucs2 NOT NULL,
  `date_added` datetime NOT NULL,
  `userid` int(225) NOT NULL,
  PRIMARY KEY (`todo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `ads_data`
--

CREATE TABLE `{tbl_prefix}ads_data` (
  `ad_id` int(50) NOT NULL AUTO_INCREMENT,
  `ad_name` mediumtext NOT NULL,
  `ad_code` mediumtext NOT NULL,
  `ad_placement` varchar(50) NOT NULL DEFAULT '',
  `ad_category` int(11) NOT NULL DEFAULT 0,
  `ad_status` enum('0','1') NOT NULL DEFAULT '0',
  `ad_impressions` bigint(255) NOT NULL DEFAULT 0,
  `last_viewed` datetime NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `ads_placements`
--

CREATE TABLE `{tbl_prefix}ads_placements` (
  `placement_id` int(20) NOT NULL AUTO_INCREMENT,
  `placement` varchar(26) NOT NULL,
  `placement_name` varchar(50) NOT NULL,
  `disable` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`placement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `collection_categories`
--

CREATE TABLE `{tbl_prefix}collection_categories` (
  `category_id` int(255) NOT NULL AUTO_INCREMENT,
  `parent_id` int(255) NOT NULL DEFAULT 1,
  `category_name` varchar(30) NOT NULL,
  `category_order` int(5) NOT NULL,
  `category_desc` text NOT NULL,
  `date_added` mediumtext NOT NULL,
  `category_thumb` mediumint(9) NOT NULL,
  `isdefault` enum('yes','no') NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `collection_contributors`
--

CREATE TABLE `{tbl_prefix}collection_contributors` (
  `contributor_id` int(200) NOT NULL AUTO_INCREMENT,
  `collection_id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `can_edit` enum('yes','no') NOT NULL DEFAULT 'no',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`contributor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `collection_items`
--

CREATE TABLE `{tbl_prefix}collection_items` (
  `ci_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(20) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`ci_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `collections`
--

CREATE TABLE `{tbl_prefix}collections` (
  `collection_id` bigint(25) NOT NULL AUTO_INCREMENT,
  `collection_name` varchar(225) NOT NULL,
  `collection_description` text NOT NULL,
  `collection_tags` text NOT NULL,
  `category` varchar(200) NOT NULL,
  `userid` int(10) NOT NULL,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `featured` varchar(4) NOT NULL DEFAULT 'no',
  `broadcast` varchar(10) NOT NULL,
  `allow_comments` varchar(4) NOT NULL,
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` bigint(20) NOT NULL DEFAULT '0',
  `last_commented` datetime NULL,
  `total_objects` bigint(20) NOT NULL DEFAULT '0',
  `rating` bigint(20) NOT NULL DEFAULT '0',
  `rated_by` bigint(20) NOT NULL DEFAULT '0',
  `voters` longtext NULL DEFAULT NULL,
  `active` varchar(4) NOT NULL,
  `public_upload` varchar(4) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`collection_id`),
  KEY `userid` (`userid`),
  KEY `featured` (`featured`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `comments`
--

CREATE TABLE `{tbl_prefix}comments` (
  `comment_id` int(60) NOT NULL AUTO_INCREMENT,
  `type` varchar(3) NOT NULL,
  `comment` text NOT NULL,
  `userid` int(60) NOT NULL,
  `anonym_name` varchar(255) NOT NULL,
  `anonym_email` varchar(255) NOT NULL,
  `parent_id` int(60) NOT NULL,
  `type_id` int(225) NOT NULL,
  `type_owner_id` int(255) NOT NULL,
  `vote` varchar(225) NOT NULL DEFAULT '',
  `voters` text NOT NULL DEFAULT '',
  `spam_votes` bigint(20) NOT NULL DEFAULT '0',
  `spam_voters` text NOT NULL DEFAULT '',
  `date_added` datetime NOT NULL,
  `comment_ip` text NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `config`
--

CREATE TABLE `{tbl_prefix}config` (
  `configid` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`configid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `contacts`
--

CREATE TABLE `{tbl_prefix}contacts` (
  `contact_id` int(225) NOT NULL AUTO_INCREMENT,
  `userid` int(225) NOT NULL,
  `contact_userid` int(225) NOT NULL,
  `confirmed` enum('yes','no') NOT NULL DEFAULT 'no',
  `contact_group_id` int(225) NOT NULL,
  `request_type` enum('in','out') NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `conversion_queue`
--

CREATE TABLE `{tbl_prefix}conversion_queue` (
  `cqueue_id` int(11) NOT NULL AUTO_INCREMENT,
  `cqueue_name` varchar(32) NOT NULL,
  `cqueue_ext` varchar(5) NOT NULL,
  `cqueue_tmp_ext` varchar(3) NOT NULL,
  `cqueue_conversion` enum('yes','no','p') NOT NULL DEFAULT 'no',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time_started` varchar(32) NOT NULL DEFAULT '0',
  `time_completed` varchar(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cqueue_id`),
  KEY `cqueue_conversion` (`cqueue_conversion`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `counters`
--

CREATE TABLE `{tbl_prefix}counters` (
  `counter_id` int(100) NOT NULL AUTO_INCREMENT,
  `section` varchar(200) NOT NULL,
  `query` text NOT NULL,
  `query_md5` varchar(200) NOT NULL,
  `counts` bigint(200) NOT NULL,
  `date_added` varchar(200) NOT NULL,
  PRIMARY KEY (`counter_id`),
  UNIQUE KEY `query_md5` (`query_md5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `countries`
--

CREATE TABLE `{tbl_prefix}countries` (
  `country_id` int(80) NOT NULL AUTO_INCREMENT,
  `iso2` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `name_en` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `is_blocked` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `editors_picks`
--

CREATE TABLE `{tbl_prefix}editors_picks` (
  `pick_id` int(225) NOT NULL AUTO_INCREMENT,
  `videoid` int(225) NOT NULL,
  `sort` bigint(5) NOT NULL DEFAULT 1,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pick_id`),
  KEY `videoid` (`videoid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `email_templates`
--

CREATE TABLE `{tbl_prefix}email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_template_name` varchar(225) NOT NULL,
  `email_template_code` varchar(225) NOT NULL,
  `email_template_subject` mediumtext NOT NULL,
  `email_template` text NOT NULL,
  `email_template_allowed_tags` mediumtext NOT NULL,
  PRIMARY KEY (`email_template_id`),
  UNIQUE KEY `email_template_code` (`email_template_code`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `favorites`
--

CREATE TABLE `{tbl_prefix}favorites` (
  `favorite_id` int(225) NOT NULL AUTO_INCREMENT,
  `type` varchar(4) NOT NULL,
  `id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `flags`
--

CREATE TABLE `{tbl_prefix}flags` (
  `flag_id` int(225) NOT NULL AUTO_INCREMENT,
  `type` varchar(4) NOT NULL,
  `id` int(225) NOT NULL,
  `userid` int(225) NOT NULL,
  `flag_type` bigint(25) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`flag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `group_categories`
--

CREATE TABLE `{tbl_prefix}group_categories` (
  `category_id` int(225) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 1,
  `category_desc` text NOT NULL,
  `date_added` mediumtext NOT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `group_invitations`
--

CREATE TABLE `{tbl_prefix}group_invitations` (
  `invitation_id` int(225) NOT NULL AUTO_INCREMENT,
  `group_id` int(225) NOT NULL,
  `userid` int(255) NOT NULL,
  `invited` int(225) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`invitation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `group_members`
--

CREATE TABLE `{tbl_prefix}group_members` (
  `group_mid` int(225) NOT NULL AUTO_INCREMENT,
  `group_id` int(225) NOT NULL,
  `userid` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`group_mid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `group_posts`
--

CREATE TABLE `{tbl_prefix}group_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_content` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `group_topics`
--

CREATE TABLE `{tbl_prefix}group_topics` (
  `topic_id` int(225) NOT NULL AUTO_INCREMENT,
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
  `approved` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `group_videos`
--

CREATE TABLE `{tbl_prefix}group_videos` (
  `group_video_id` int(225) NOT NULL AUTO_INCREMENT,
  `videoid` int(255) NOT NULL,
  `group_id` int(225) NOT NULL,
  `userid` int(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`group_video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `groups`
--

CREATE TABLE `{tbl_prefix}groups` (
  `group_id` int(225) NOT NULL AUTO_INCREMENT,
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
  `total_topics` int(225) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `languages`
--

CREATE TABLE `{tbl_prefix}languages` (
  `language_id` int(9) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `language_regex` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `language_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `language_default` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `language_default` (`language_default`),
  KEY `language_code` (`language_code`,`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `mass_emails`
--

CREATE TABLE `{tbl_prefix}mass_emails` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
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
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `messages`
--

CREATE TABLE `{tbl_prefix}messages` (
  `message_id` int(225) NOT NULL AUTO_INCREMENT,
  `message_from` int(20) NOT NULL,
  `message_to` varchar(200) NOT NULL,
  `message_content` mediumtext NOT NULL,
  `message_type` enum('pm','notification') NOT NULL DEFAULT 'pm',
  `message_attachments` mediumtext NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `message_subject` mediumtext NOT NULL,
  `message_status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `reply_to` int(225) NOT NULL DEFAULT 0,
  `message_box` enum('in','out') NOT NULL DEFAULT 'in',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `modules`
--

CREATE TABLE `{tbl_prefix}modules` (
  `module_id` int(25) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(25) NOT NULL,
  `module_file` varchar(60) NOT NULL,
  `active` varchar(5) NOT NULL,
  `module_include_file` text NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `pages`
--

CREATE TABLE `{tbl_prefix}pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_order` bigint(100) NOT NULL,
  `display` enum('yes','no') NOT NULL DEFAULT 'yes',
  `page_name` varchar(225) NOT NULL,
  `page_title` varchar(225) NOT NULL,
  `page_content` text NOT NULL,
  `userid` int(225) NOT NULL,
  `active` enum('yes','no') NOT NULL,
  `delete_able` enum('yes','no') NOT NULL DEFAULT 'yes',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `active` (`active`,`display`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `photos`
--

CREATE TABLE `{tbl_prefix}photos` (
  `photo_id` bigint(255) NOT NULL AUTO_INCREMENT,
  `photo_key` mediumtext NOT NULL,
  `photo_title` mediumtext NOT NULL,
  `photo_description` mediumtext NOT NULL,
  `photo_tags` mediumtext NOT NULL,
  `userid` int(255) NOT NULL,
  `collection_id` int(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `last_viewed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `views` bigint(255) NOT NULL DEFAULT '0',
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_embedding` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_tagging` enum('yes','no') NOT NULL DEFAULT 'yes',
  `featured` enum('yes','no') NOT NULL DEFAULT 'no',
  `reported` enum('yes','no') NOT NULL DEFAULT 'no',
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `broadcast` enum('public','private') NOT NULL DEFAULT 'public',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` int(255) NOT NULL DEFAULT '0',
  `last_commented` datetime NULL DEFAULT NULL,
  `total_favorites` int(255) NOT NULL DEFAULT '0',
  `rating` int(15) NOT NULL DEFAULT '0',
  `rated_by` int(25) NOT NULL DEFAULT '0',
  `voters` mediumtext NULL DEFAULT NULL,
  `filename` varchar(100) NOT NULL,
  `file_directory` varchar(25) NOT NULL,
  `ext` char(5) NOT NULL,
  `downloaded` bigint(255) NOT NULL DEFAULT '0',
  `server_url` text NOT NULL DEFAULT '',
  `owner_ip` varchar(20) NOT NULL,
  `photo_details` text NOT NULL DEFAULT '',
  PRIMARY KEY (`photo_id`),
  KEY `userid` (`userid`),
  KEY `collection_id` (`collection_id`),
  KEY `featured` (`featured`),
  KEY `last_viewed` (`last_viewed`),
  KEY `rating` (`rating`),
  KEY `total_comments` (`total_comments`),
  KEY `last_viewed_2` (`last_viewed`),
  FULLTEXT KEY `photo_title` (`photo_title`,`photo_tags`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `phrases`
--

CREATE TABLE `{tbl_prefix}phrases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_iso` varchar(5) NOT NULL DEFAULT 'en',
  `varname` varchar(250) NOT NULL DEFAULT '',
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `playlist_items`
--

CREATE TABLE `{tbl_prefix}playlist_items` (
  `playlist_item_id` int(225) NOT NULL AUTO_INCREMENT,
  `object_id` int(225) NOT NULL,
  `playlist_id` int(225) NOT NULL,
  `playlist_item_type` varchar(10) NOT NULL,
  `userid` int(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`playlist_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `playlists`
--

CREATE TABLE `{tbl_prefix}playlists` (
  `playlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_name` varchar(225) NOT NULL,
  `userid` int(11) NOT NULL,
  `playlist_type` varchar(10) NOT NULL,
  `category` enum('normal','favorites','likes','history','quicklist','watch_later') NOT NULL DEFAULT 'normal',
  `description` mediumtext NOT NULL,
  `tags` mediumtext NOT NULL,
  `privacy` enum('public','private','unlisted') NOT NULL DEFAULT 'public',
  `allow_comments` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_rating` enum('yes','no') NOT NULL DEFAULT 'yes',
  `total_comments` int(255) NOT NULL,
  `total_items` int(255) NOT NULL,
  `rating` int(3) NOT NULL,
  `rated_by` int(255) NOT NULL,
  `voters` text NOT NULL,
  `last_update` text NOT NULL,
  `runtime` int(200) NOT NULL,
  `first_item` text NOT NULL,
  `cover` text NOT NULL,
  `played` int(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`playlist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `plugin_config`
--

CREATE TABLE `{tbl_prefix}plugin_config` (
  `plugin_config_id` int(223) NOT NULL AUTO_INCREMENT,
  `plugin_id_code` varchar(25) NOT NULL,
  `plugin_config_name` text NOT NULL,
  `plugin_config_value` text NOT NULL,
  `player_type` enum('built-in','plugin') NOT NULL DEFAULT 'built-in',
  `player_admin_file` text NOT NULL,
  `player_include_file` text NOT NULL,
  PRIMARY KEY (`plugin_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `plugins`
--

CREATE TABLE `{tbl_prefix}plugins` (
  `plugin_id` int(255) NOT NULL AUTO_INCREMENT,
  `plugin_file` text NOT NULL,
  `plugin_folder` text NOT NULL,
  `plugin_version` float NOT NULL,
  `plugin_license_type` varchar(10) NOT NULL DEFAULT 'GPL',
  `plugin_license_key` varchar(5) NOT NULL,
  `plugin_license_code` text NOT NULL,
  `plugin_active` enum('yes','no') NOT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `sessions`
--

CREATE TABLE `{tbl_prefix}sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(100) NOT NULL,
  `session_user` int(11) NOT NULL,
  `session_string` varchar(60) NOT NULL,
  `session_value` varchar(32) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `session_date` datetime NOT NULL,
  `current_page` text NOT NULL,
  `referer` text NOT NULL,
  `agent` text NOT NULL,
  `last_active` datetime NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `session` (`session`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `stats`
--

CREATE TABLE `{tbl_prefix}stats` (
  `stat_id` int(255) NOT NULL AUTO_INCREMENT,
  `date_added` date NOT NULL,
  `video_stats` text NOT NULL,
  `user_stats` text NOT NULL,
  `group_stats` text NOT NULL,
  PRIMARY KEY (`stat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `{tbl_prefix}subscriptions` (
  `subscription_id` int(225) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `subscribed_to` mediumtext NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`subscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `template`
--

CREATE TABLE `{tbl_prefix}template` (
  `template_id` int(20) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(25) NOT NULL,
  `template_dir` varchar(30) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_categories`
--

CREATE TABLE `{tbl_prefix}user_categories` (
  `category_id` int(225) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 1,
  `category_desc` text NOT NULL,
  `date_added` mediumtext NOT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_levels`
--

CREATE TABLE `{tbl_prefix}user_levels` (
  `user_level_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_level_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `user_level_name` varchar(100) NOT NULL,
  `user_level_is_default` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`user_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_levels_permissions`
--

CREATE TABLE `{tbl_prefix}user_levels_permissions` (
  `user_level_permission_id` int(22) NOT NULL AUTO_INCREMENT,
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
  `plugins_perms` text NOT NULL DEFAULT '',
  `allow_manage_user_level` enum('yes','no') NOT NULL DEFAULT 'no',
  `allow_create_collection` enum('yes','no') NOT NULL DEFAULT 'yes',
  `allow_create_playlist` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`user_level_permission_id`),
  KEY `user_level_id` (`user_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_permission_types`
--

CREATE TABLE `{tbl_prefix}user_permission_types` (
  `user_permission_type_id` int(225) NOT NULL AUTO_INCREMENT,
  `user_permission_type_name` varchar(225) NOT NULL,
  `user_permission_type_desc` mediumtext NOT NULL,
  PRIMARY KEY (`user_permission_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `{tbl_prefix}user_permissions` (
  `permission_id` int(225) NOT NULL AUTO_INCREMENT,
  `permission_type` int(225) NOT NULL,
  `permission_name` varchar(225) NOT NULL,
  `permission_code` varchar(225) NOT NULL,
  `permission_desc` mediumtext NOT NULL,
  `permission_default` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_code` (`permission_code`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_profile`
--

CREATE TABLE `{tbl_prefix}user_profile` (
  `user_profile_id` int(11) NOT NULL,
  `show_my_collections` enum('yes','no') NOT NULL DEFAULT 'yes',
  `userid` bigint(20) NOT NULL,
  `profile_title` mediumtext DEFAULT '',
  `profile_desc` mediumtext DEFAULT '',
  `featured_video` mediumtext DEFAULT '',
  `first_name` varchar(100) NOT NULL DEFAULT '',
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `avatar` varchar(225) NOT NULL DEFAULT 'no_avatar.jpg',
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
  `about_me` mediumtext DEFAULT '',
  `education` varchar(3) DEFAULT NULL,
  `schools` mediumtext DEFAULT '',
  `occupation` mediumtext DEFAULT '',
  `companies` mediumtext DEFAULT '',
  `relation_status` varchar(15) DEFAULT NULL,
  `hobbies` mediumtext DEFAULT '',
  `fav_movies` mediumtext DEFAULT '',
  `fav_music` mediumtext DEFAULT '',
  `fav_books` mediumtext DEFAULT '',
  `background` mediumtext DEFAULT '',
  `profile_video` int(255) DEFAULT NULL,
  `profile_item` varchar(25) DEFAULT '',
  `rating` tinyint(2) DEFAULT NULL,
  `voters` text DEFAULT '',
  `rated_by` int(150) DEFAULT NULL,
  `show_my_videos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_photos` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_subscriptions` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_subscribers` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_my_friends` enum('yes','no') NOT NULL DEFAULT 'yes'
  PRIMARY KEY (`user_profile_id`),
  KEY `ind_status_id` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--

CREATE TABLE `{tbl_prefix}users` (
  `userid` bigint(20) NOT NULL AUTO_INCREMENT,
  `category` int(20) NOT NULL,
  `featured_video` mediumtext NOT NULL DEFAULT '',
  `username` text NOT NULL,
  `user_session_key` varchar(32) NOT NULL,
  `user_session_code` int(5) NOT NULL,
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL DEFAULT '',
  `usr_status` enum('Ok','ToActivate') NOT NULL DEFAULT 'ToActivate',
  `msg_notify` enum('yes','no') NOT NULL DEFAULT 'yes',
  `avatar` varchar(225) NOT NULL DEFAULT '',
  `avatar_url` text NOT NULL DEFAULT '',
  `sex` enum('male','female') NOT NULL DEFAULT 'male',
  `dob` date NOT NULL DEFAULT '0000-00-00',
  `country` varchar(20) NOT NULL DEFAULT 'PK',
  `level` int(6) NOT NULL DEFAULT 2,
  `avcode` mediumtext NOT NULL,
  `doj` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_logged` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
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
  `background_attachement` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_groups` bigint(20) NOT NULL DEFAULT 0,
  `last_active` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `banned_users` text DEFAULT NULL,
  `welcome_email_sent` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_downloads` bigint(255) NOT NULL DEFAULT 0,
  `album_privacy` enum('public','private','friends') NOT NULL DEFAULT 'private',
  `likes` int(11) NOT NULL DEFAULT 0,
  `is_live` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`userid`),
  KEY `ind_status_doj` (`doj`),
  KEY `ind_status_id` (`userid`),
  KEY `ind_hits_doj` (`profile_hits`,`doj`),
  KEY `username` (`username`(255),`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `validation_re`
--

CREATE TABLE `{tbl_prefix}validation_re` (
  `re_id` int(25) NOT NULL AUTO_INCREMENT,
  `re_name` varchar(60) NOT NULL,
  `re_code` varchar(60) NOT NULL,
  `re_syntax` text NOT NULL,
  PRIMARY KEY (`re_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `video`
--

CREATE TABLE `{tbl_prefix}video` (
  `videoid` bigint(20) NOT NULL AUTO_INCREMENT,
  `videokey` mediumtext NOT NULL,
  `video_password` varchar(255) NOT NULL,
  `video_users` text NOT NULL,
  `username` text NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `flv` mediumtext NOT NULL DEFAULT '',
  `file_name` varchar(32) NOT NULL,
  `file_type` int(10) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `tags` mediumtext NOT NULL,
  `category` varchar(200) NOT NULL DEFAULT '0',
  `category_parents` text NOT NULL DEFAULT '',
  `broadcast` varchar(10) NOT NULL DEFAULT '',
  `location` mediumtext DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  `country` mediumtext DEFAULT NULL,
  `blocked_countries` text NOT NULL DEFAULT '',
  `sprite_count` int(11) NOT NULL DEFAULT 0,
  `allow_embedding` char(3) NOT NULL DEFAULT '',
  `rating` int(15) NOT NULL DEFAULT 0,
  `rated_by` varchar(20) NOT NULL DEFAULT '0',
  `voter_ids` mediumtext NOT NULL DEFAULT '',
  `allow_comments` char(3) NOT NULL DEFAULT '',
  `comment_voting` char(3) NOT NULL DEFAULT '',
  `comments_count` int(15) NOT NULL DEFAULT 0,
  `last_commented` datetime DEFAULT NULL,
  `subscription_email` enum('pending','sent') NOT NULL DEFAULT 'pending',
  `featured` char(3) NOT NULL DEFAULT 'no',
  `featured_date` datetime DEFAULT NULL,
  `featured_description` mediumtext NOT NULL DEFAULT '',
  `allow_rating` char(3) NOT NULL DEFAULT '',
  `active` char(3) NOT NULL DEFAULT '0',
  `favourite_count` varchar(15) NOT NULL DEFAULT '0',
  `playlist_count` varchar(15) NOT NULL DEFAULT '0',
  `views` bigint(22) NOT NULL DEFAULT 0,
  `last_viewed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_added` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `flagged` varchar(3) NOT NULL DEFAULT 'no',
  `duration` varchar(20) NOT NULL DEFAULT '00',
  `status` enum('Successful','Processing','Failed') NOT NULL DEFAULT 'Processing',
  `failed_reason` enum('none','max_duration','max_file','invalid_format','invalid_upload') NOT NULL DEFAULT 'none',
  `flv_file_url` text DEFAULT NULL,
  `default_thumb` int(3) NOT NULL DEFAULT 1,
  `aspect_ratio` varchar(10) NOT NULL DEFAULT '',
  `embed_code` text NOT NULL DEFAULT '',
  `refer_url` text NOT NULL DEFAULT '',
  `downloads` bigint(255) NOT NULL DEFAULT 0,
  `uploader_ip` varchar(20) NOT NULL,
  `mass_embed_status` enum('no','pending','approved') NOT NULL DEFAULT 'no',
  `is_hd` enum('yes','no') NOT NULL DEFAULT 'no',
  `unique_embed_code` varchar(50) NOT NULL DEFAULT '',
  `remote_play_url` text NOT NULL DEFAULT '',
  `video_files` tinytext NOT NULL DEFAULT '',
  `server_ip` varchar(20) NOT NULL DEFAULT '',
  `file_server_path` text NOT NULL DEFAULT '',
  `file_directory` varchar(10) NOT NULL,
  `files_thumbs_path` text NOT NULL DEFAULT '',
  `file_thumbs_count` varchar(30) NOT NULL DEFAULT '',
  `has_hq` enum('yes','no') NOT NULL DEFAULT 'no',
  `has_mobile` enum('yes','no') NOT NULL DEFAULT 'no',
  `filegrp_size` varchar(30) NOT NULL DEFAULT '',
  `process_status` bigint(30) NOT NULL DEFAULT 0,
  `has_hd` enum('yes','no') NOT NULL DEFAULT 'no',
  `video_version` varchar(30) NOT NULL DEFAULT '2.6',
  `extras` varchar(225) NOT NULL DEFAULT '',
  `thumbs_version` varchar(5) NOT NULL DEFAULT '2.6',
  `re_conv_status` tinytext NOT NULL DEFAULT '',
  `conv_progress` text NOT NULL DEFAULT '',
  `is_castable` boolean NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`videoid`),
  KEY `userid` (`userid`),
  KEY `featured` (`featured`),
  KEY `last_viewed` (`last_viewed`),
  KEY `rating` (`rating`),
  KEY `comments_count` (`comments_count`),
  KEY `last_viewed_2` (`last_viewed`),
  KEY `status` (`status`,`active`,`broadcast`,`userid`),
  KEY `userid_2` (`userid`),
  KEY `videoid` (`videoid`,`videokey`(255)),
  FULLTEXT KEY `title` (`title`,`tags`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `video_categories`
--

CREATE TABLE `{tbl_prefix}video_categories` (
  `category_id` int(225) NOT NULL AUTO_INCREMENT,
  `parent_id` int(255) NOT NULL DEFAULT 0,
  `category_name` varchar(30) NOT NULL DEFAULT '',
  `category_order` int(5) NOT NULL DEFAULT 1,
  `category_desc` text NOT NULL,
  `date_added` mediumtext NOT NULL,
  `category_thumb` mediumtext NOT NULL,
  `isdefault` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `video_favourites`
--

CREATE TABLE `{tbl_prefix}video_favourites` (
  `fav_id` int(11) NOT NULL AUTO_INCREMENT,
  `videoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`fav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `video_files`
--

CREATE TABLE `{tbl_prefix}video_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `hq` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `video_views`
--

CREATE TABLE `{tbl_prefix}video_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(255) NOT NULL,
  `video_views` int(11) NOT NULL,
  `last_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
