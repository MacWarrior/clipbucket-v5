SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'plugin_compatible';
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES (@language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = @language_key), 'Plugin is compatible with current Clipbucket version', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = @language_key), 'Le plugin est compatible avec la version actuelle de Clipbucket', @language_id_fra);

SET @language_key = 'plugin_not_compatible';
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES (@language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = @language_key), 'Plugin might not be compatible with current Clipbucket version', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = @language_key), 'Le plugin peut ne pas être compatible avec la version actuelle de Clipbucket', @language_id_fra);
