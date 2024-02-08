ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN IF EXISTS filegrp_size,
	DROP COLUMN IF EXISTS file_thumbs_count,
	DROP COLUMN IF EXISTS conv_progress,
	DROP COLUMN IF EXISTS is_hd,
	MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT '5.5.0',
	MODIFY COLUMN `thumbs_version` varchar(5) NOT NULL DEFAULT '5.5.0',
    DROP COLUMN IF EXISTS has_hd,
    DROP COLUMN IF EXISTS has_mobile,
    DROP COLUMN IF EXISTS has_hq,
    DROP COLUMN IF EXISTS extras,
    DROP COLUMN IF EXISTS mass_embed_status,
	MODIFY COLUMN `file_type` VARCHAR(3) NULL DEFAULT NULL;

UPDATE `{tbl_prefix}video` SET file_type = 'mp4';

INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('conversion_type', 'mp4');
