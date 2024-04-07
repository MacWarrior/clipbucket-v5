CREATE TABLE IF NOT EXISTS `{tbl_prefix}editors_picks` (
    `pick_id` int(225) NOT NULL AUTO_INCREMENT,
    `videoid` int(225) NOT NULL,
    `sort` bigint(5) NOT NULL DEFAULT '1',
    `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`pick_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci AUTO_INCREMENT=1;

ALTER TABLE `{tbl_prefix}video` ADD `in_editor_pick` varchar(255) DEFAULT 'no';

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
SET @language_id_fr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');
SET @language_id_de = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
SET @language_id_ptbr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');
SET @language_id_esp = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'esp');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Redaktionelle Auswahl');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Escolha do Editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_added');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Video has been added to Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'La vidéo a été ajoutée au choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Video wurde zur redaktionellen Auswahl hinzugefügt');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'O vídeo foi adicionado à Escolha do Editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_removed');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Video has been removed from Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'La vidéo a été retirée du choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Video wurde aus der redaktionellen Auswahl entfernt');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'O vídeo foi removido da Escolha do Editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_removed_plural');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Selected video has been removed from Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Les vidéos sélectionnées ont été retirées du choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Ausgewähltes Video wurde aus der redaktionellen Auswahl entfernt');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'O vídeo selecionado foi removido da Escolha do Editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_add_error');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Video is already in the Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Cette vidéo est déjà dans les choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Video ist bereits in der redaktionellen Auswahl enthalten');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'O vídeo já está na Escolha do Editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_add_to');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Add to Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Ajouter au choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Zur redaktionellen Auswahl hinzufügen');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Adicionar à Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_esp, @id_language_key, 'Añadir a la selección del editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_remove_from');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Remove from Editor\'s Pick');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Retirer du choix de l\'éditeur');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Von der redaktionellen Auswahl entfernen');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Remover da Escolha do Editor');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_esp, @id_language_key, 'Eliminar de la selección del editor');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_editors_picks_remove_confirm');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Are you sure you want to remove selected videos from Editor\'s Pick ?');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Êtes-vous sûr de vouloir retirer les vidéos sélectionnées du choix de l\'éditeur ?');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_de, @id_language_key, 'Wollen Sie das ausgewählte Videos wirklich aus der redaktionellen Auswahl entfernen?');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_ptbr, @id_language_key, 'Tem certeza de que deseja remover os vídeos selecionados da Escolha do Editor?');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_esp, @id_language_key, '¿Estás seguro de que deseas eliminar los videos seleccionados de la Selección del editor?');
