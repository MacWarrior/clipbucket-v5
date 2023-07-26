CREATE TABLE IF NOT EXISTS `{tbl_prefix}global_announcement` (
    `announcement` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `{tbl_prefix}global_announcement` (announcement)
VALUES ('');

INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key)
VALUES
    ('plugin_global_announcement'),
    ('plugin_global_announcement_subtitle'),
    ('plugin_global_announcement_edit'),
    ('plugin_global_announcement_updated');

SET @language_id_en = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement'), 'Global Announcement');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_subtitle'), 'Global Announcement Manager');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_edit'), 'Edit global announcement');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_updated'), 'Global announcement has been updated');

SET @language_id_fr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement'), 'Annonce Globale');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_subtitle'), 'Gestionnaire d\'annonce');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_edit'), 'Editer l\'annonce');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_updated'), 'L\'annonce a été mise à jour');

SET @language_id_de = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement'), 'Globaler Ankündigung');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_subtitle'), 'Globaler Ankündigungs manager');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_edit'), 'Globale Ankündigung bearbeiten');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_updated'), 'Global announcement has been updated');

SET @language_id_ptbr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement'), 'Anúncio Global');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_subtitle'), 'Gerenciador de Anúncios Globais');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_edit'), 'Editar anúncio global');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_updated'), 'O anúncio global foi atualizado');
