SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'add_more' COLLATE utf8mb4_unicode_520_ci;
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Rajouter', @language_id_fra);