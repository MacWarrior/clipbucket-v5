DELETE FROM `{tbl_prefix}config` WHERE `name` IN (
	'cb_license'
	,'cb_license_local'
	,'use_ffmpeg_vf'
	,'buffer_time'
	,'server_friendly_conversion'
	,'cbhash'
	,'enable_troubleshooter'
	,'debug_level'
	,'sys_os'
	,'con_modules_type'
	,'version_type'
	,'version'
	,'user_comment_opt1'
	,'user_comment_opt2'
	,'user_comment_opt3'
	,'user_comment_opt4'
	,'ffmpeg_type'
	,'date_released'
	,'stream_via'
	,'use_watermark'
	,'hq_output'
	,'date_installed'
	,'date_updated'
	,'max_topic_length'
	,'default_time_zone'
	,'user_max_chr'
	,'captcha_type'
	,'user_rate_opt1'
	,'max_time_wait'
	,'index_featured'
	,'index_recent'
	,'videos_items_columns'
);

DROP TABLE `{tbl_prefix}modules`;

ALTER TABLE `{tbl_prefix}contacts` MODIFY COLUMN `contact_group_id` INT(255) NOT NULL DEFAULT '0';

ALTER TABLE `{tbl_prefix}ads_data`
    MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	DROP `ad_category`;

ALTER TABLE `{tbl_prefix}video_categories`
	MODIFY COLUMN `category_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `date_added` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `category_thumb` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}collection_categories`
	MODIFY COLUMN `category_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `category_order` INT(5) NOT NULL DEFAULT '0',
	MODIFY COLUMN `category_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `date_added` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT NOW(),
	MODIFY COLUMN `category_thumb` MEDIUMINT(9) NOT NULL DETAULT '0',
	MODIFY COLUMN `isdefault` ENUM('yes','no') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';

ALTER TABLE `{tbl_prefix}playlists`
	MODIFY COLUMN `playlist_name` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `userid` INT(11) NOT NULL DEFAULT '0',
	MODIFY COLUMN `playlist_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `tags` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `total_comments` INT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_items` INT(255) NOT NULL DETAULT '0',
	MODIFY COLUMN `rating` INT(3) NOT NULL DETAULT '0',
	MODIFY COLUMN `rated_by` INT(255) NOT NULL DETAULT '0',
	MODIFY COLUMN `voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `last_update` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `runtime` INT(200) NOT NULL DETAULT '0',
	MODIFY COLUMN `first_item` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `cover` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
	MODIFY COLUMN `played` INT(255) NOT NULL DETAULT '0';