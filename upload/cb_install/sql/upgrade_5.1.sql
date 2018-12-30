INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('chromecast_fix', '1');

UPDATE `{tbl_prefix}config` SET name = 'allowed_video_types' WHERE name = 'allowed_types';
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('allowed_photo_types', 'jpg,jpeg,png');

DELETE FROM `{tbl_prefix}config` WHERE name = 'users_items_subscribers';

UPDATE `{tbl_prefix}config` SET value = CONCAT(value, ',mkv') WHERE name = 'allowed_video_types' AND value NOT LIKE '%mkv%';
UPDATE `{tbl_prefix}config` SET value = CONCAT(value, ',webm') WHERE name = 'allowed_video_types' AND value NOT LIKE '%webm%';

DELETE FROM `{tbl_prefix}config` WHERE name IN(
	'max_topic_title',
	'max_topic_length',
	'groups_list_per_page',
	'grps_items_search_page',
	'users_items_group_page',
	'videos_items_grp_page');