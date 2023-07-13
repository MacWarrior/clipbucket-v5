SET @language_id_eng = 1;
SET @language_id_fra = 2;
SET @language_id_deu = 3;
SET @language_id_por = 4;

INSERT INTO {tbl_prefix}languages_keys (language_key) VALUES ('code');

ALTER TABLE `{tbl_prefix}languages_translations` MODIFY COLUMN `translation` VARCHAR(1024) NOT NULL;

INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_eng, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'code'), 'Code');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fra, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'code'), 'Code');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_deu, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'code'), 'Code');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_por, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'code'), 'Código');

ALTER TABLE `{tbl_prefix}languages` ADD COLUMN `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

UPDATE  `{tbl_prefix}languages` SET `language_code`='en' WHERE language_id = @language_id_eng;
UPDATE  `{tbl_prefix}languages` SET `language_code`='fr' WHERE language_id = @language_id_fra;
UPDATE  `{tbl_prefix}languages` SET `language_code`='de' WHERE language_id = @language_id_deu;
UPDATE  `{tbl_prefix}languages` SET `language_code`='pt-BR' WHERE language_id = @language_id_por;

ALTER TABLE `{tbl_prefix}languages` CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL UNIQUE;
