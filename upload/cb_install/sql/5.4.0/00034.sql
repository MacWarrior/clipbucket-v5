ALTER TABLE `{tbl_prefix}ads_data`
    MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    DROP `ad_category`;
