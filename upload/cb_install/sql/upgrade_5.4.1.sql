INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('email_domain_restriction', ''),
	('proxy_enable', 'no'),
	('proxy_auth', 'no'),
	('proxy_url', ''),
	('proxy_port', ''),
	('proxy_username', ''),
	('proxy_password', '');

DELETE FROM `{tbl_prefix}config` WHERE name IN('mp4boxpath','quick_conv');

UPDATE `{tbl_prefix}config` SET value = 'no' WHERE name = 'enable_advertisement' AND value = '0';

ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `videokey` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `video_password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `video_users` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `userid` INT(11) NULL DEFAULT NULL,
	MODIFY COLUMN `file_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `tags` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `uploader_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `file_directory` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}video_categories`
	MODIFY COLUMN `category_thumb` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}comments`
	MODIFY COLUMN `userid` int(60) NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}plugins`
	MODIFY COLUMN `plugin_version` VARCHAR(32) NOT NULL;

ALTER TABLE `{tbl_prefix}users`
	DROP `background_attachement`;

ALTER TABLE `{tbl_prefix}user_profile`
	MODIFY COLUMN `avatar` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_avatar.png';

ALTER TABLE `{tbl_prefix}user_categories`
	MODIFY COLUMN `category_thumb` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}photos`
	MODIFY COLUMN `server_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `photo_details` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}action_log`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}ads_data`
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}collection_categories`
	MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}comments`
	MODIFY COLUMN `voters` text NULL DEFAULT NULL,
	MODIFY COLUMN `spam_voters` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}conversion_queue`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_categories`
	MODIFY COLUMN `date_added` datetime NOT NULL;

ALTER TABLE `{tbl_prefix}group_invitations`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_members`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_videos`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}messages`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}photos`
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
    MODIFY COLUMN `server_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `photo_details` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}playlists`
	MODIFY COLUMN `voters` text NULL DEFAULT NULL,
	MODIFY COLUMN `last_update` text NULL DEFAULT NULL,
	MODIFY COLUMN `first_item` text NULL DEFAULT NULL,
	MODIFY COLUMN `cover` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    MODIFY COLUMN `description` mediumtext NOT NULL,
    MODIFY COLUMN `tags` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}playlist_items`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}subscriptions`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}users`
	MODIFY COLUMN `avatar_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `dob` date NOT NULL DEFAULT '1000-01-01',
	MODIFY COLUMN `doj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	MODIFY COLUMN `last_logged` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
	MODIFY COLUMN `last_active` datetime NOT NULL DEFAULT 0,
    MODIFY COLUMN `featured_video` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}user_categories`
	MODIFY COLUMN `date_added` datetime NOT NULL,
	MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `username` text NULL DEFAULT NULL,
	MODIFY COLUMN `category_parents` text NULL DEFAULT NULL,
	MODIFY COLUMN `blocked_countries` text NULL DEFAULT NULL,
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	MODIFY COLUMN `embed_code` text NULL DEFAULT NULL,
	MODIFY COLUMN `refer_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `remote_play_url` text NULL DEFAULT NULL,
	MODIFY COLUMN `video_files` tinytext NULL DEFAULT NULL,
	MODIFY COLUMN `file_server_path` text NULL DEFAULT NULL,
	MODIFY COLUMN `files_thumbs_path` text NULL DEFAULT NULL,
	MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT '5.4.1',
	MODIFY COLUMN `thumbs_version` varchar(5) NOT NULL DEFAULT '5.4.1',
	MODIFY COLUMN `re_conv_status` tinytext NULL DEFAULT NULL,
	MODIFY COLUMN `conv_progress` text NULL DEFAULT NULL,
    DROP COLUMN `flv`,
    DROP COLUMN `flv_file_url`,
    MODIFY COLUMN `voter_ids` mediumtext NOT NULL,
    MODIFY COLUMN `featured_description` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video_categories`
	MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NULL DEFAULT NULL,
	MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video_favourites`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;
