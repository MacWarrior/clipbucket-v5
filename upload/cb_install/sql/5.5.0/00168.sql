INSERT INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('update_castable_status_label', 'update_castable_status_description', 'AdminTool::updateCastableStatus', 1, NULL, NULL);
INSERT INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('update_bits_color_label', 'update_bits_color_description', 'AdminTool::updateBitsColor', 1, NULL, NULL);
INSERT INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('update_videos_duration_label', 'update_videos_duration_description', 'AdminTool::updateVideoDuration', 1, NULL, NULL);

SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_castable_status_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_castable_status_label'), 'Update videos castable status', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_castable_status_label'), 'Mise à jour du statut de diffusion des vidéos', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_castable_status_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_castable_status_description'), 'Update all videos castable status, based on video files', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_castable_status_description'), 'Met à jour le statut de diffusion de toutes les vidéos, en se basant sur les fichiers vidéo', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_bits_color_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_bits_color_label'), 'Update video colors encoding status', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_bits_color_label'), 'Mise à jour du statut d\'encodage des couleurs des vidéos', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_bits_color_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_bits_color_description'), 'Update all videos color encoding status, based on video files', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_bits_color_description'), 'Met à jour le statut d\'encodage des couleurs des vidéos, en se basant sur les fichiers vidéo', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_videos_duration_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_videos_duration_label'), 'Update videos durations', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_videos_duration_label'), 'Mise à jour des durées des vidéos', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('update_videos_duration_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_videos_duration_description'), 'Update all videos durations, based on video files', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_videos_duration_description'), 'Met à jour la durée de toutes les vidéos, en se basant sur les fichiers vidéo', @language_id_fra);
