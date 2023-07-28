ALTER TABLE `{tbl_prefix}collections`
    DROP INDEX IF EXISTS `userid_2`,
    DROP INDEX IF EXISTS `featured_2`;

ALTER TABLE `{tbl_prefix}conversion_queue`
    DROP INDEX IF EXISTS `cqueue_conversion_2`;

ALTER TABLE `{tbl_prefix}favorites`
    DROP INDEX IF EXISTS `userid_2`;

ALTER TABLE `{tbl_prefix}languages`
    DROP INDEX IF EXISTS `language_default_2`,
    DROP INDEX IF EXISTS `language_code_2`;

ALTER TABLE `{tbl_prefix}pages`
    DROP INDEX IF EXISTS `active_2`;

ALTER TABLE `{tbl_prefix}photos`
    DROP INDEX IF EXISTS `last_viewed_2`,
    DROP INDEX IF EXISTS `userid_2`,
    DROP INDEX IF EXISTS `collection_id_2`,
    DROP INDEX IF EXISTS `featured_2`,
    DROP INDEX IF EXISTS `last_viewed_3`,
    DROP INDEX IF EXISTS `rating_2`,
    DROP INDEX IF EXISTS `total_comments_2`,
    DROP INDEX IF EXISTS `last_viewed_4`;

ALTER TABLE `{tbl_prefix}sessions`
    DROP INDEX IF EXISTS `session_2`;

ALTER TABLE `{tbl_prefix}users`
    DROP INDEX IF EXISTS `username_2`;

ALTER TABLE `{tbl_prefix}user_levels_permissions`
    DROP INDEX IF EXISTS `user_level_id_2`;

ALTER TABLE `{tbl_prefix}video`
    DROP INDEX IF EXISTS `last_viewed_2`,
    DROP INDEX IF EXISTS `userid_2`,
    DROP INDEX IF EXISTS `userid_3`,
    DROP INDEX IF EXISTS `featured_2`,
    DROP INDEX IF EXISTS `last_viewed_3`,
    DROP INDEX IF EXISTS `rating_2`,
    DROP INDEX IF EXISTS `comments_count_2`,
    DROP INDEX IF EXISTS `last_viewed_4`,
    DROP INDEX IF EXISTS `status_2`,
    DROP INDEX IF EXISTS `userid_4`,
    DROP INDEX IF EXISTS `videoid_2`;
