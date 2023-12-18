INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`)
VALUES
    ('display_video_comments', 'yes'),
    ('display_photo_comments', 'yes'),
    ('display_channel_comments', 'no');

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'option_display_video_comments' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Display video comments', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Afficher les commentaires vidéos', @language_id_fra);

SET @language_key = 'option_display_photo_comments' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Display photo comments', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Afficher les commentaires photos', @language_id_fra);

SET @language_key = 'option_display_channel_comments' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Display channel comments', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Afficher les commentaires de chaîne', @language_id_fra);

SET @language_key = 'comment_disabled_for' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Comments are disabled for this %s', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Les commentaires sont désactivés pour cette %s', @language_id_fra);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Kommentare deaktiviert für dieses %s', @language_id_deu);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Comentários desativados para este vídeo %s', @language_id_por);

ALTER TABLE `{tbl_prefix}comments` MODIFY type varchar(16);

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'comm_disabled_for_vid');
DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;
DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'comm_disabled_for_collection');
DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;
DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'comments_disabled_for_photo');
DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;
DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;
