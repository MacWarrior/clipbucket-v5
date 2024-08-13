CREATE TABLE IF NOT EXISTS `{tbl_prefix}plugin_cb_social_beast` (
    `id` int(20) NOT NULL AUTO_INCREMENT,
    `facebook` TEXT NOT NULL DEFAULT '',
    `twitter` TEXT NOT NULL DEFAULT '',
    `google` TEXT NOT NULL DEFAULT '',
    `linkedin` TEXT NOT NULL DEFAULT '',
    `pinterest` TEXT NOT NULL DEFAULT '',
    `reddit` TEXT NOT NULL DEFAULT '',
    `youtube` TEXT NOT NULL DEFAULT '',
    `vine` TEXT NOT NULL DEFAULT '',
    `rss` TEXT NOT NULL DEFAULT '',
    `github` TEXT NOT NULL DEFAULT '',
    `dropbox` TEXT NOT NULL DEFAULT '',
    `stumbleupon` TEXT NOT NULL DEFAULT '',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

INSERT IGNORE INTO `{tbl_prefix}plugin_cb_social_beast` (id) VALUES (NULL);

INSERT IGNORE INTO `{tbl_prefix}languages_keys` (language_key)
VALUES
    ('plugin_cb_social_beast_menu'),
    ('plugin_cb_social_beast_subtitle');

SET @language_id_en = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fr = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_cb_social_beast_menu');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Social networks');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Réseaux sociaux');

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_cb_social_beast_subtitle');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_en, @id_language_key, 'Social networks manager');
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
    VALUES (@language_id_fr, @id_language_key, 'Gestionnaire de réseaux sociaux');

