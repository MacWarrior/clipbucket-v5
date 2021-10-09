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
	MODIFY COLUMN `video_password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `userid` INT(11) NULL DEFAULT NULL,
	MODIFY COLUMN `file_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `uploader_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `file_directory` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

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
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
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
	MODIFY COLUMN `last_active` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
    MODIFY COLUMN `featured_video` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}user_categories`
	MODIFY COLUMN `date_added` datetime NOT NULL,
	MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `username` text NULL DEFAULT NULL,
	MODIFY COLUMN `category_parents` text NULL DEFAULT NULL,
	MODIFY COLUMN `blocked_countries` text NULL DEFAULT NULL,
	MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
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
    MODIFY COLUMN `featured_description` mediumtext NOT NULL,
	MODIFY COLUMN `videokey` MEDIUMTEXT NULL DEFAULT NULL,
	MODIFY COLUMN `video_users` TEXT NOT NULL,
	MODIFY COLUMN `tags` MEDIUMTEXT NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}video_categories`
	MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
	MODIFY COLUMN `date_added` datetime NULL DEFAULT NULL,
	MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video_favourites`
	MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE `{tbl_prefix}video_resolution` (
	`id_video_resolution` int(11) NOT NULL,
	`title` varchar(32) NOT NULL DEFAULT '',
	`ratio` varchar(8) NOT NULL DEFAULT '',
	`enabled` tinyint(1) NOT NULL DEFAULT 1,
	`width` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`height` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`video_bitrate` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_resolution`
	ADD PRIMARY KEY (`id_video_resolution`),
	ADD UNIQUE KEY `title` (`title`);

ALTER TABLE `{tbl_prefix}video_resolution`
	MODIFY `id_video_resolution` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `{tbl_prefix}video_resolution` (`title`, `ratio`, `enabled`, `width`, `height`, `video_bitrate`) VALUES
	('240p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 0 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_240') END), 428, 240, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_240')),
	('360p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 1 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_360') END), 640, 360, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_360')),
	('480p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 0 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_480') END), 854, 480, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_480')),
	('720p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 1 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_720') END), 1280, 720, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_720')),
	('1080p', '16/9', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = 'cb_combo_res') = 'no' THEN 0 ELSE (SELECT CASE WHEN value = 'yes' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = 'gen_1080') END), 1920, 1080, (SELECT value FROM `{tbl_prefix}config` WHERE name = 'vbrate_1080')),
	('1440p', '16/9', 0, 2560, 1440, 7280000),
	('2160p', '16/9', 0, 4096, 2160, 17472000);

DELETE FROM `{tbl_prefix}config` WHERE name IN('gen_240','gen_360','gen_480','gen_720','gen_1080','cb_combo_res','vbrate','vbrate_hd','vbrate_240','vbrate_360','vbrate_480','vbrate_720','vbrate_1080');

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('player_default_resolution', '360');
