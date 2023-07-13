ALTER TABLE `{tbl_prefix}photos`
    MODIFY COLUMN `server_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `photo_details` text NULL DEFAULT NULL;
