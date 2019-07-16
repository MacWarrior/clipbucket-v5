INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('logo_name', ''),
	('favicon_name', '');

ALTER TABLE `{tbl_prefix}user_levels_permissions` MODIFY COLUMN `plugins_perms` text NOT NULL DEFAULT '';
ALTER TABLE `{tbl_prefix}users`
    MODIFY COLUMN `featured_video` mediumtext DEFAULT '' NOT NULL,
    MODIFY COLUMN `avatar_url` text DEFAULT '' NOT NULL,
    MODIFY COLUMN `featured_date` DATETIME NULL DEFAULT NULL,
	MODIFY COLUMN `total_videos` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_comments` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_photos` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `total_collections` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `comments_count` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
	MODIFY COLUMN `total_subscriptions` BIGINT(255) NOT NULL DEFAULT '0',
	MODIFY COLUMN `background` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `background_color` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `background_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `total_groups` BIGINT(20) NOT NULL DEFAULT '0',
	MODIFY COLUMN `banned_users` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	MODIFY COLUMN `total_downloads` BIGINT(255) NOT NULL DEFAULT '0';