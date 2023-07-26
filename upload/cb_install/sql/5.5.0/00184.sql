SET @language_id_eng = 1;
SET @language_id_fra = 2;

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('open_debug');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'open_debug'), 'SQL requests', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'open_debug'), 'Requêtes SQL', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('select_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'select_queries'), 'Select Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'select_queries'), 'Requêtes Select', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('update_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_queries'), 'Update Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_queries'), 'Requêtes Update', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('delete_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'delete_queries'), 'Delete Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'delete_queries'), 'Requêtes Delete', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('insert_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'insert_queries'), 'Insert Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'insert_queries'), 'Requêtes Insert', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('execute_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'execute_queries'), 'Execute Query', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'execute_queries'), 'Requêtes Execute', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('expensive_query');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'expensive_query'), 'Expensive Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'expensive_query'), 'Requête la plus lourde', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('cheapest_query');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'cheapest_query'), 'Cheapest Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'cheapest_query'), 'Requête la plus légère', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('overall_stats');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'overall_stats'), 'Overall Stats', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'overall_stats'), 'Statistiques Globales', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('base_directory');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'base_directory'), 'Base directory', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'base_directory'), 'Dossier racine', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'queries'), 'Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'queries'), 'Requêtes', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('all_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'all_queries'), 'All Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'all_queries'), 'Toutes les Requêtes', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('total_db_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_db_queries'), 'Total DB Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_db_queries'), 'Nombre total de requêtes SQL', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('total_cache_queries');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_cache_queries'), 'Total cache Queries', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_cache_queries'), 'Nombre total de requêtes en cache', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('total_execution_time');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_execution_time'), 'Total Execution Time', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_execution_time'), 'Temps total d\'exécution', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('total_memory_used');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_memory_used'), 'Total Memory Used', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'total_memory_used'), 'Consomation mémoire totale', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('memory_usage');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'memory_usage'), 'Memory Usage', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'memory_usage'), 'Consomation mémoire', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('everything');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'everything'), 'Everything', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'everything'), 'Tout', @language_id_fra);

INSERT INTO `{tbl_prefix}languages_keys` (`language_key`)
VALUES ('display');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'display'), 'Display', @language_id_eng);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'display'), 'Afficher', @language_id_fra);
