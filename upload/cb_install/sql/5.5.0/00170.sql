SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('system_info');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'system_info'), 'System Info', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'system_info'), 'Information système', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('hosting');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'hosting'), 'Hosting', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'hosting'), 'Hébergement', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('info_ffmpeg');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_ffmpeg'), 'is used to covert videos from different versions to FLV , MP4 and many other formats.', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_ffmpeg'), 'est utilisé pour convertir des vidéos aux formats FLV, MP4 et de nombreux autres formats.', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('tool_box');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'tool_box'), 'Tool Box', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'tool_box'), 'Boîte à Outils', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('info_php_cli');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_php_cli'), 'is used to perform video conversion in a background process.', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_php_cli'), 'est utilisé pour lancer la conversion vidéo en arrière plan', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('info_media_info');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_media_info'), 'supplies technical and tag information about a video or audio file.', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_media_info'), 'fournit des informations techniques sur un fichier vidéo ou audio', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('info_ffprobe');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_ffprobe'), 'is an Extension of FFMPEG used to get info of media file', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_ffprobe'), 'est une extension de FFMPEG utilsié pour récupérer des informations pour les fichiers multimédias', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('info_php_web');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_php_web'), 'is used to display this page', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_php_web'), 'est utilisé pour afficher cette page', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('must_be_least');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'must_be_least'), 'must be at least', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'must_be_least'), 'doit être au moins', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('php_cli_not_found');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'php_cli_not_found'), 'PHP CLI is not correctly configured', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`) VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'php_cli_not_found'), 'PHP CLI n\'est pas correctement configuré', @language_id_fra);

