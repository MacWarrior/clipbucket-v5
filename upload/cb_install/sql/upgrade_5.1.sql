INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('chromecast_fix', '1');

UPDATE `{tbl_prefix}config` SET name = 'allowed_video_types' WHERE name = 'allowed_types';
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('allowed_photo_types', 'jpg,jpeg,png');

DELETE FROM `{tbl_prefix}config` WHERE name = 'users_items_subscibers';

UPDATE `{tbl_prefix}config` SET value = CONCAT(value, ',mkv') WHERE name = 'allowed_video_types' AND value NOT LIKE '%mkv%';
UPDATE `{tbl_prefix}config` SET value = CONCAT(value, ',webm') WHERE name = 'allowed_video_types' AND value NOT LIKE '%webm%';