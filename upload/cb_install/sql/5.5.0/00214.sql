ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN `remote_play_url`;

DELETE FROM `{tbl_prefix}languages_translations`
WHERE `id_language_key` IN(
    SELECT id_language_key FROM `{tbl_prefix}languages_keys`
    WHERE `language_key` IN(
        'link_video_msg',
        'remote_play'
    )
);

DELETE FROM `{tbl_prefix}languages_keys`
WHERE `language_key` IN(
        'link_video_msg',
        'remote_play'
);

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'video_upload_disabled' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Video Upload is disabled', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'L\'envoi de vidéo est désactivé', @language_id_fra);