SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('reset_video_log_label', 'reset_video_log_description', 'AdminTool::resetVideoLog', 1, NULL, NULL);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('reset_video_log_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_video_log_label'), 'Delete conversion logs', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_video_log_label'), 'Suppression des logs de conversion', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('reset_video_log_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_video_log_description'), 'Delete conversion logs of videos successfully converted', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_video_log_description'), 'Supprime les logs de conversion des vidéos correctement converties', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('no_conversion_log');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'no_conversion_log'), 'No conversion log file available', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'no_conversion_log'), 'Aucun fichier de log disponible', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('watch_conversion_log');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'watch_conversion_log'), 'See Conversion log', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'watch_conversion_log'), 'Voir le log de conversion', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('conversion_log');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'conversion_log'), 'Conversion log', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'conversion_log'), 'Log de conversion', @language_id_fra);
