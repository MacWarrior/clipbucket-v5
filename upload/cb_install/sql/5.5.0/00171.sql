SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('cache');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'cache'), 'cache', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'cache'), 'cache', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('enable_cache');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'enable_cache'), 'Enable cache', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'enable_cache'), 'Activer le cache', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES ('enable_cache_authentification');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'enable_cache_authentification'), 'Enable cache authentification', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'enable_cache_authentification'), 'Activer l\'authentification du cache', @language_id_fra);

INSERT INTO `{tbl_prefix}config` (`name`, `value`)
VALUES ('cache_enable', 'no'), ('cache_auth', 'no'), ('cache_host', ''), ('cache_password', ''), ('cache_port', '');

INSERT INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('reset_cache_label', 'reset_cache_description', 'AdminTool::resetCache', 1, NULL, NULL);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('reset_cache_label');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_cache_label'), 'Reset Cache', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_cache_label'), 'Réinitialisation du cache', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('reset_cache_description');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_cache_description'), 'Clear all entries from cache', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_cache_description'), 'Vide toutes les entrées du cache', @language_id_fra);
