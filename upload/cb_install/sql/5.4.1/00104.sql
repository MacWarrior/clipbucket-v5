ALTER TABLE `{tbl_prefix}playlists`
    MODIFY COLUMN `description` mediumtext NOT NULL,
    MODIFY COLUMN `tags` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}users`
    MODIFY COLUMN `featured_video` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}user_categories`
    MODIFY COLUMN `category_thumb` mediumtext NOT NULL;

ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN `flv`,
    MODIFY COLUMN `voter_ids` mediumtext NOT NULL,
    MODIFY COLUMN `featured_description` mediumtext NOT NULL;
