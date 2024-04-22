INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES ('enable_tmdb_mature_content', 'no');
INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES ('tmdb_mature_content_age', '18');

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'enable_tmdb_mature_content' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Enable mature content', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Activer le contenu mature', @language_id_fra);

SET @language_key = 'tmdb_mature_content_age' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Minimal age for adult content', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Âge minimum du contenu pour adulte', @language_id_fra);

set @var=if((SELECT true FROM information_schema.COLUMNS WHERE
    TABLE_SCHEMA = DATABASE() AND
    TABLE_NAME   = '{tbl_prefix}tmdb_search_result' AND
    COLUMN_NAME  = 'is_adult')
    ,'SELECT 1'
    , 'ALTER TABLE `{tbl_prefix}tmdb_search_result` ADD COLUMN `is_adult` BOOLEAN'
 );
prepare stmt from @var;
execute stmt;
deallocate prepare stmt;

SET @language_key = 'access_forbidden_under_age_display' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, '- %s', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, '- %s', @language_id_fra);

ALTER TABLE `{tbl_prefix}tmdb_search_result` CHANGE `title` `title` VARCHAR(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;
