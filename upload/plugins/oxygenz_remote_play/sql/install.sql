ALTER TABLE `{tbl_prefix}video`
    ADD `remote_play_url` TEXT NULL DEFAULT NULL;

INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key)
VALUES
    ('plugin_oxygenz_remote_play_remote_play'),
    ('plugin_oxygenz_remote_play_invalid_duration'),
    ('plugin_oxygenz_remote_play_form_description'),
    ('plugin_oxygenz_remote_play_input_url'),
    ('plugin_oxygenz_remote_play_input_url_example'),
    ('plugin_oxygenz_remote_play_checking'),
    ('plugin_oxygenz_remote_play_invalid_step'),
    ('plugin_oxygenz_remote_play_invalid_url'),
    ('plugin_oxygenz_remote_play_invalid_extension'),
    ('plugin_oxygenz_remote_play_website_not_responding'),
    ('plugin_oxygenz_remote_play_url_not_working'),
    ('plugin_oxygenz_remote_play_not_valid_video'),
    ('plugin_oxygenz_remote_play_saving'),
    ('plugin_oxygenz_remote_play_saving_error'),
    ('plugin_oxygenz_remote_play_video_saved');

SET @language_id_en = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');
SET @language_id_de = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
SET @language_id_ptbr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_remote_play');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Remote play');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Lecture à distance');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Entfernte Wiedergabe');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Reprodução remota');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_invalid_duration');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Invalid duration');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Durée invalide');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Ungültige Dauer');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Duração inválida');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_form_description');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Add a video by it\'s URL ; video file won\'t be uploaded but just linked');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Ajoutez une vidéo par son URL ; le fichier vidéo ne sera pas télécharger mais juste lié');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_input_url');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Video URL');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'URL de la vidéo');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_input_url_example');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'e.g %s');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'e.g %s');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_checking');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Checking link...');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Vérification du lien...');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_invalid_step');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Invalid step');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Etape invalide');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_invalid_url');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'URL provides is invalid');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'L\'URL fournie est invalide');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_invalid_extension');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'File extension is invalid');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'L\'extension du fichier est invalide');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_website_not_responding');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Inputted website is not responding');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Le site renseigné ne répond pas');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_url_not_working');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Inputted URL is not working');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'L\'URL indiquée ne fonctionne pas');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_not_valid_video');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'File isn\'t a valid video');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Le fichier n\'est pas une vidéo valide');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_saving');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Saving video...');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Sauvegarde de la vidéo...');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_saving_error');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'You can only update your own video');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Vous ne pouvez mettre à jour que votre vidéo');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_oxygenz_remote_play_video_saved');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Video has been saved');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'La vidéo a été sauvegardée');
