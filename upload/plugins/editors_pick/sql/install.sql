CREATE TABLE IF NOT EXISTS `{tbl_prefix}editors_picks` (
    `pick_id` int(225) NOT NULL AUTO_INCREMENT,
    `videoid` int(225) NOT NULL,
    `sort` bigint(5) NOT NULL DEFAULT '1',
    `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`pick_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `{tbl_prefix}video` ADD IF NOT EXISTS `in_editor_pick` varchar(255) DEFAULT 'no';

INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key)
VALUES
    ('plugin_editors_picks'),
    ('plugin_editors_picks_added'),
    ('plugin_editors_picks_removed'),
    ('plugin_editors_picks_removed_plural'),
    ('plugin_editors_picks_add_error'),
    ('plugin_editors_picks_add_to'),
    ('plugin_editors_picks_remove_from'),
    ('plugin_editors_picks_remove_confirm');

SET @language_id_en = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks'), 'Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_added'), 'Video has been added to Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed'), 'Video has been removed from Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed_plural'), 'Selected video has been removed from Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_error'), 'Video is already in the Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_to'), 'Add to Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_from'), 'Remove from Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_en, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_confirm'), 'Are you sure you want to remove selected videos from Editor\'s Pick ?');

SET @language_id_fr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks'), 'Choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_added'), 'La vidéo a été ajoutée au choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed'), 'La vidéo a été retirée du choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed_plural'), 'Les vidéos sélectionnées ont été retirées du choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_error'), 'Cette vidéo est déjà dans les choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_to'), 'Ajouter au choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_from'), 'Retirer du choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_fr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_confirm'), 'Êtes-vous sûr de vouloir retirer les vidéos sélectionnées du choix de l\'éditeur ?');

SET @language_id_de = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks'), 'Redaktionelle Auswahl');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_added'), 'Video wurde zur redaktionellen Auswahl hinzugefügt');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed'), 'Video wurde aus der redaktionellen Auswahl entfernt');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed_plural'), 'Ausgewähltes Video wurde aus der redaktionellen Auswahl entfernt');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_error'), 'Video ist bereits in der redaktionellen Auswahl enthalten');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_to'), 'Zur redaktionellen Auswahl hinzufügen');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_from'), 'Von der redaktionellen Auswahl entfernen');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_de, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_confirm'), 'Wollen Sie das ausgewählte Videos wirklich aus der redaktionellen Auswahl entfernen?');

SET @language_id_ptbr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks'), 'Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_added'), 'O vídeo foi adicionado à Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed'), 'O vídeo foi removido da Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed_plural'), 'O vídeo selecionado foi removido da Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_error'), 'O vídeo já está na Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_to'), 'Adicionar à Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_from'), 'Remover da Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id_ptbr, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_confirm'), 'Tem certeza de que deseja remover os vídeos selecionados da Escolha do Editor?');
