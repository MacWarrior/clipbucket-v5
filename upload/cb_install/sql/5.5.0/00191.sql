SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('number');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'number'), 'Number', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'number'), 'Numéro', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('confirm_delete_subtitle_file');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'confirm_delete_subtitle_file'), 'Are you sure you want to delete subtitle track n°%s ?', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'confirm_delete_subtitle_file'), 'Êtes vous certains de vouloir supprimer la piste de sous titre n°%s ?', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('video_subtitle_management');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'video_subtitle_management'), 'Video subtitle file management', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'video_subtitle_management'), 'Gestion des fichiers de sous-titre', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('video_subtitles_deleted_num');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'video_subtitles_deleted_num'), 'Subtitle track n°%s has been deleted', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'video_subtitles_deleted_num'), 'La piste n°%s des sous-titres a été supprimée', @language_id_fra);
