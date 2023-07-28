INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('video_age_verification', 'yes');

ALTER TABLE `{tbl_prefix}video`
    ADD `age_required` INT NULL DEFAULT NULL;
