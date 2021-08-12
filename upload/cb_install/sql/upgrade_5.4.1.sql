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

ALTER TABLE `{tbl_prefix}video`
    ADD COLUMN `subscription_email` VARCHAR(16) NOT NULL DEFAULT '';

ALTER TABLE `{tbl_prefix}users`
	DROP `background_attachement`;

