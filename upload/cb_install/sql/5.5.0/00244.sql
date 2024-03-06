ALTER TABLE `{tbl_prefix}video`
    DROP `blocked_countries`,
    DROP `sprite_count`,
    DROP `failed_reason`,
    DROP `category_parents`,
    DROP `featured_description`,
    DROP `aspect_ratio`,
    DROP `files_thumbs_path`,
    DROP `unique_embed_code`,
    DROP `refer_url`,
    DROP `server_ip`,
    DROP `process_status`;

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'grab_from_youtube');

DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;
DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;

DELETE FROM `{tbl_prefix}config` WHERE name = 'youtube_api_key';
