INSERT INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('update_database_version_label', 'update_database_version_description', 'AdminTool::updateDataBaseVersion', 1, NULL, NULL);

SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('need_db_upgrade');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'need_db_upgrade'), 'You have <b>%s</b> files to execute to upgrade your database. You can use this following link :  ', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'need_db_upgrade'), 'Vous avez <b>%s</b> fichiers de mise à jour à exécuter. Pour cela vous pouvez utiliser le lien suivant : ', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('db_up_to_date');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'db_up_to_date'), 'Your database is up to date', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'db_up_to_date'), 'Votre base de données est à jour', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_database_version_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_database_version_label'), 'Update your database to current version', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_database_version_label'), 'Mise à jour de la base de données à la version actuelle', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_database_version_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_database_version_description'), 'Execute all sql required files to update database', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_database_version_description'), 'Exécute tous les fichiers nécessaires pour mettre à jour la base de données', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('no_version');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'no_version'), 'Your ClipBucket use the old database upgrade system. Please execute all sql migration files to version 5.3.0 before continue.', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'no_version'), 'Votre ClipBucket utilise l\'ancien système de mise à jour. Merci d\'exéctuer les fichiers de migration jusqu\'à la version 5.3.0. avant de poursuivre.', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('select_version');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'select_version'), 'Please select you current version and revision', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'select_version'), 'Merci de sélectionner votre version et révision courante.', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('version');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'version'), 'version', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'version'), 'version', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('revision');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'revision'), 'revision', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'revision'), 'révision', @language_id_fra);
