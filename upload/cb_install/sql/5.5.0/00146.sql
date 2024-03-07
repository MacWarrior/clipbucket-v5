ALTER TABLE `{tbl_prefix}collections`
    DROP INDEX `userid_2`,
    DROP INDEX `featured_2`;

ALTER TABLE `{tbl_prefix}conversion_queue`
    DROP INDEX `cqueue_conversion_2`;

ALTER TABLE `{tbl_prefix}favorites`
    DROP INDEX `userid_2`;

ALTER TABLE `{tbl_prefix}languages`
    DROP INDEX `language_default_2`,
    DROP INDEX `language_code_2`;

ALTER TABLE `{tbl_prefix}pages`
    DROP INDEX `active_2`;

ALTER TABLE `{tbl_prefix}photos`
    DROP INDEX `last_viewed_2`,
    DROP INDEX `userid_2`,
    DROP INDEX `collection_id_2`,
    DROP INDEX `featured_2`,
    DROP INDEX `last_viewed_3`,
    DROP INDEX `rating_2`,
    DROP INDEX `total_comments_2`,
    DROP INDEX `last_viewed_4`;

ALTER TABLE `{tbl_prefix}sessions`
    DROP INDEX `session_2`;

ALTER TABLE `{tbl_prefix}users`
    DROP INDEX `username_2`;

ALTER TABLE `{tbl_prefix}user_levels_permissions`
    DROP INDEX `user_level_id_2`;

ALTER TABLE `{tbl_prefix}video`
    DROP INDEX `last_viewed_2`,
    DROP INDEX `userid_2`,
    DROP INDEX `userid_3`,
    DROP INDEX `featured_2`,
    DROP INDEX `last_viewed_3`,
    DROP INDEX `rating_2`,
    DROP INDEX `comments_count_2`,
    DROP INDEX `last_viewed_4`,
    DROP INDEX `status_2`,
    DROP INDEX `userid_4`,
    DROP INDEX `videoid_2`;
