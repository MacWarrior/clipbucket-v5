UPDATE `{tbl_prefix}config` SET value = '0' WHERE `name` = 'activation' AND `value` = '';

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_deu = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
SET @language_id_por = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

UPDATE `{tbl_prefix}languages_keys` SET `language_key` = 'videos_details' WHERE `language_key` = 'videos_Details';
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos_details');

INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_por, @id_language_key, 'Detalhes dos Vídeos');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_deu, @id_language_key, 'Details zu den Videos');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_eng, @id_language_key, 'Videos Details');
