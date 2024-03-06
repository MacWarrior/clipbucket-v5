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

INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('conversion_type', 'mp4');
