INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('chromecast_fix', '1');

UPDATE `{tbl_prefix}config` SET name = 'allowed_video_types' WHERE name = 'allowed_types';
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('allowed_photo_types', 'jpg,jpeg,png');