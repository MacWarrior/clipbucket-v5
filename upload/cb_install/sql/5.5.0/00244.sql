ALTER TABLE `{tbl_prefix}video`
    DROP IF EXISTS `blocked_countries`,
    DROP IF EXISTS `sprite_count`,
    DROP IF EXISTS `failed_reason`,
    DROP IF EXISTS `category_parents`,
    DROP IF EXISTS `featured_description`,
    DROP IF EXISTS `aspect_ratio`,
    DROP IF EXISTS `files_thumbs_path`,
    DROP IF EXISTS `unique_embed_code`,
    DROP IF EXISTS `refer_url`,
    DROP IF EXISTS `server_ip`,
    DROP IF EXISTS `process_status`;

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'grab_from_youtube');

DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;
DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;

DELETE FROM `{tbl_prefix}config` WHERE name = 'youtube_api_key';
