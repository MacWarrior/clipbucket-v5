CREATE TABLE `{tbl_prefix}tools`
(
    `id_tool`                  INT          NOT NULL AUTO_INCREMENT,
    `language_key_label`       VARCHAR(128) NOT NULL,
    `language_key_description` VARCHAR(128) NOT NULL,
    `function_name`            VARCHAR(128) NOT NULL,
    `id_tools_status`          INT          NOT NULL DEFAULT '1',
    `elements_total`           INT          NULL     DEFAULT NULL,
    `elements_done`            INT          NULL     DEFAULT NULL,
    PRIMARY KEY (`id_tool`)
) ENGINE = InnoDB;

CREATE TABLE `{tbl_prefix}tools_status`
(
    `id_tools_status`    INT          NOT NULL AUTO_INCREMENT,
    `language_key_title` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id_tools_status`)
) ENGINE = InnoDB;

ALTER TABLE `{tbl_prefix}tools`
    ADD FOREIGN KEY (`id_tools_status`) REFERENCES `{tbl_prefix}tools_status` (`id_tools_status`) ON DELETE RESTRICT ON UPDATE NO ACTION;

SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('admin_tool');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'admin_tool'), 'Administrations Tools', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'admin_tool'), 'Outils d\'administration', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('launch');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'launch'), 'Launch', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'launch'), 'Lancer', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('stop');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'stop'), 'Stop', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'stop'), 'Arrêter', @language_id_fra);

INSERT INTO `{tbl_prefix}tools_status` (`language_key_title`) VALUES ('ready'), ('in_progress'), ('stopping');
INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('in_progress');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'in_progress'), 'In progress', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'in_progress'), 'En cours', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('ready');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'ready'), 'Ready', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'ready'), 'Prêt', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('stopping');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'stopping'), 'Stopping', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'stopping'), 'En cours d\'arrêt', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('generate_missing_thumbs_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'generate_missing_thumbs_label'), 'Generate missing thumbs', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'generate_missing_thumbs_label'), 'Génération des miniatures manquantes', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('generate_missing_thumbs_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'generate_missing_thumbs_description'), 'Generate thumbs for all videos without thumbs', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'generate_missing_thumbs_description'), 'Génération des miniatures pour toutes les vidéos qui n\'ont pas de miniatures', @language_id_fra);
