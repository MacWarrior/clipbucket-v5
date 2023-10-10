ALTER TABLE `{tbl_prefix}video_thumbs`
    ADD COLUMN `type` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

UPDATE `{tbl_prefix}video_thumbs` SET `type` = 'auto' WHERE `type` IS NULL;

ALTER TABLE `{tbl_prefix}video_thumbs` ADD INDEX(`type`);