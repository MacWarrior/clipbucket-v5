-- REV 3
DELETE FROM `{tbl_prefix}config` WHERE name IN('keep_original');

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('keep_audio_tracks', '1'),
	('keep_subtitles', '1');

-- REV 4
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('extract_subtitles', '1');

CREATE TABLE `{tbl_prefix}video_subtitle` (
	`videoid` bigint(20) NOT NULL,
	`number` varchar(2) NOT NULL,
	`title` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_subtitle`
	ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_subtitle`
	ADD CONSTRAINT `{tbl_prefix}video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

-- REV 5
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('extract_audio_tracks', '1');

CREATE TABLE `{tbl_prefix}video_audio_tracks` (
	`videoid` bigint(20) NOT NULL,
	`number` varchar(2) NOT NULL,
	`title` varchar(64) NOT NULL,
	`channels` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_audio_tracks`
	ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_audio_tracks`
	ADD CONSTRAINT `{tbl_prefix}video_audio_tracks_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

-- REV 6
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('player_subtitles', '1'),
	('subtitle_format', 'webvtt');

-- REV 7
DELETE FROM `{tbl_prefix}config` WHERE name = 'extract_audio_tracks';
DROP TABLE `{tbl_prefix}video_audio_tracks`;

-- REV 8
ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN filegrp_size,
	DROP COLUMN file_thumbs_count,
	DROP COLUMN conv_progress,
	DROP COLUMN is_hd,
	MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT '5.5.0',
	MODIFY COLUMN `thumbs_version` varchar(5) NOT NULL DEFAULT '5.5.0',
    DROP COLUMN has_hd,
    DROP COLUMN has_mobile,
    DROP COLUMN has_hq,
    DROP COLUMN extras,
    DROP COLUMN mass_embed_status,
	MODIFY COLUMN `file_type` VARCHAR(3) NULL DEFAULT NULL;

UPDATE `{tbl_prefix}video` SET file_type = 'mp4';

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('conversion_type', 'mp4');

-- REV 9
DELETE FROM `{tbl_prefix}config` WHERE name IN(
	'high_resolution'
	,'normal_resolution'
	,'videos_list_per_tab'
	,'channels_list_per_tab'
	,'code_dev'
	,'player_div_id'
	,'channel_player_width'
	,'channel_player_height'
	,'use_crons'
    ,'grp_max_title'
    ,'grp_max_desc'
    ,'grp_thumb_width'
    ,'grp_thumb_height'
    ,'grp_categories'
    ,'max_bg_height'
    ,'max_profile_pic_height'
);

-- REV 36
ALTER TABLE `{tbl_prefix}collection_categories`
	MODIFY COLUMN `category_thumb` MEDIUMTEXT NOT NULL;

-- REV 43
ALTER TABLE `{tbl_prefix}collections`
    ADD `collection_id_parent` BIGINT(25) NULL DEFAULT NULL AFTER `collection_id`,
	ADD INDEX(`collection_id_parent`);
ALTER TABLE `{tbl_prefix}collections`
	ADD FOREIGN KEY (`collection_id_parent`) REFERENCES `{tbl_prefix}collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
	('enable_sub_collection', '1');

-- REV 49
INSERT INTO `{tbl_prefix}languages` (`language_id`, `language_code`, `language_name`, `language_regex`, `language_active`, `language_default`) VALUES
	(3, 'de', 'German', '/^de/i', 'yes', 'no');

-- REV 57
ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `category` VARCHAR(200) NULL DEFAULT NULL;

-- REV 77
ALTER TABLE `{tbl_prefix}video`
	MODIFY COLUMN `datecreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
