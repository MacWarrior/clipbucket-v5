ALTER TABLE `{tbl_prefix}languages`
    ADD COLUMN `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

SET @language_id_eng = 1;
SET @language_id_fra = 2;
SET @language_id_deu = 3;
SET @language_id_por = 4;

UPDATE `{tbl_prefix}languages`
    SET `language_code`='en' WHERE language_id = @language_id_eng;
UPDATE `{tbl_prefix}languages`
    SET `language_code`='fr' WHERE language_id = @language_id_fra;
UPDATE `{tbl_prefix}languages`
    SET `language_code`='de' WHERE language_id = @language_id_deu;
UPDATE `{tbl_prefix}languages`
    SET `language_code`='pt-BR' WHERE language_id = @language_id_por;

UPDATE `{tbl_prefix}languages`
    SET `language_code`=language_id WHERE language_code IS NULL OR language_code = '';

ALTER TABLE `{tbl_prefix}languages`
    CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL UNIQUE;

ALTER TABLE `{tbl_prefix}languages_translations` 
    MODIFY COLUMN `translation` VARCHAR(1024) NOT NULL;

SET @language_key = 'code' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_eng, @id_language_key, 'Code');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fra, @id_language_key, 'Code');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_deu, @id_language_key, 'Code');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_por, @id_language_key, 'Código');
