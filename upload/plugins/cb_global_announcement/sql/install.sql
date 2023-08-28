CREATE TABLE IF NOT EXISTS `{tbl_prefix}plugin_cb_global_announcement` (
    `announcement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

INSERT IGNORE INTO `{tbl_prefix}plugin_cb_global_announcement` (announcement)
VALUES ('');

INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key)
VALUES
    ('plugin_cb_global_announcement_menu'),
    ('plugin_cb_global_announcement_subtitle'),
    ('plugin_cb_global_announcement_edit'),
    ('plugin_cb_global_announcement_updated');

SET @language_id_en = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');
SET @language_id_de = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
SET @language_id_ptbr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_cb_global_announcement_menu');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Global Announcement');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Annonce Globale');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Globaler Ankündigung');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Anúncio Global');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_cb_global_announcement_subtitle');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Global Announcement Manager');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Gestionnaire d\'annonce');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Globaler Ankündigungs manager');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Gerenciador de Anúncios Globais');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_cb_global_announcement_edit');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Edit global announcement');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Editer l\'annonce');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Globale Ankündigung bearbeiten');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Editar anúncio global');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_cb_global_announcement_updated');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Global announcement has been updated');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'L\'annonce a été mise à jour');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Global announcement has been updated');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'O anúncio global foi atualizado');
