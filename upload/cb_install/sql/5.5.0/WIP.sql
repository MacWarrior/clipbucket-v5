INSERT IGNORE INTO `{tbl_prefix}config` (`configid`, `name`, `value`)
VALUES (NULL, 'tmdb_token', ''),
       (NULL, 'enable_tmdb', 'no'),
       (NULL, 'tmdb_get_genre', 'yes'),
       (NULL, 'tmdb_get_actors', 'yes'),
       (NULL, 'tmdb_get_producer', 'yes'),
       (NULL, 'tmdb_get_executive_producer', 'yes'),
       (NULL, 'tmdb_get_director', 'yes'),
       (NULL, 'tmdb_get_crew', 'yes'),
       (NULL, 'tmdb_get_poster', 'no'),
       (NULL, 'tmdb_get_release_date', 'yes'),
       (NULL, 'tmdb_get_title', 'yes'),
       (NULL, 'tmdb_get_description', 'yes'),
       (NULL, 'tmdb_get_backdrop', 'no'),
       (NULL, 'tmdb_get_age_restriction', 'yes'),
       (NULL, 'enable_video_genre', 'yes'),
       (NULL, 'enable_video_actor', 'yes'),
       (NULL, 'enable_video_producer', 'yes'),
       (NULL, 'enable_video_executive_producer', 'yes'),
       (NULL, 'enable_video_director', 'yes'),
       (NULL, 'enable_video_crew', 'yes'),
       (NULL, 'enable_video_poster', 'no'),
       (NULL, 'enable_video_backdrop', 'no'),
       (NULL, 'tmdb_search', '10');

ALTER TABLE `{tbl_prefix}video_thumbs`
    MODIFY COLUMN `num` MEDIUMINT NOT NULL;

ALTER TABLE `{tbl_prefix}tags_type`
    ADD UNIQUE IF NOT EXISTS `name` (`name`);
INSERT IGNORE INTO `{tbl_prefix}tags_type` (name) VALUES ('actors'), ('producer'), ('executive_producer'), ('director'), ('crew'), ('genre');

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'enable_tmdb' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Enable TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Activer TMDB', @language_id_fra);

SET @language_key = 'tmdb_token' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'TMDB authentification token', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Token d\'authentification TMDB', @language_id_fra);

SET @language_key = 'tmdb_token_check' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Check TMDB token', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Vérifier le token TMDB', @language_id_fra);

SET @language_key = 'get_data_tmdb' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get info from The Movie DataBase', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer les infos depuis The Movie DataBase', @language_id_fra);

SET @language_key = 'release_date' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Release date', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Date de sortie', @language_id_fra);

SET @language_key = 'poster' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Poster', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Affiche', @language_id_fra);

SET @language_key = 'import' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Import', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Importer', @language_id_fra);

SET @language_key = 'actors' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Actors', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Acteurs', @language_id_fra);

SET @language_key = 'producer' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Producer', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Producteur', @language_id_fra);

SET @language_key = 'crew' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Crew', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Equipe', @language_id_fra);

SET @language_key = 'genre' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Genre', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Genre', @language_id_fra);

SET @language_key = 'executive_producer' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Executive Producer', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Producteur exécutif', @language_id_fra);

SET @language_key = 'director' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Director', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Directeur', @language_id_fra);

SET @language_key = 'option_tmdb_get_genre' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get genre from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer le genre depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_actors' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get actors from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer les acteurs depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_producer' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get producer from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer le producteur depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_executive_producer' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get executive producer from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer le producteur exécutif depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_director' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get director from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer le directeur depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_crew' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get crew from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer l\'équipe depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_poster' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get poster from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer l\'affiche depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_release_date' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get release date from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer la date de sortie depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_title' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get title from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer le titre depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_description' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get description from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer la description depuis TMDB', @language_id_fra);

SET @language_key = 'tmdb_search' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'The Movie Database search', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Recherche The Movie Database', @language_id_fra);

SET @language_key = 'movie_infos' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Movie infos', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Informations sur le film', @language_id_fra);

SET @language_key = 'option_enable_video_poster' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Enable poster', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Activer les affiches', @language_id_fra);

SET @language_key = 'option_enable_video_backdrop' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Enable backdrop', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Activer les décors', @language_id_fra);

SET @language_key = 'option_tmdb_get_age_restriction' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get age restriction from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer la restriction d\'âge depuis TMDB', @language_id_fra);

SET @language_key = 'option_tmdb_get_backdrop' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Get backdrop from TMDB', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Récupérer le décors depuis TMDB', @language_id_fra);

ALTER TABLE `{tbl_prefix}video` ADD COLUMN IF NOT EXISTS `default_poster` INT(3) DEFAULT NULL;
ALTER TABLE `{tbl_prefix}video` ADD COLUMN IF NOT EXISTS `default_backdrop` INT(3) DEFAULT NULL;

SET @language_key = 'sort_by' COLLATE utf8mb4_unicode_520_ci;
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
DELETE FROM `{tbl_prefix}languages_translations` WHERE id_language_key = @id_language_key;
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Sort by %s', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Trier par %s', @language_id_fra);

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tmdb_search`
(
    `id_tmdb_search`  INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `search_key`      VARCHAR(128) NOT NULL UNIQUE,
    `datetime_search` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total_results`   INT          NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tmdb_search_result`
(
    `id_tmdb_search_result` INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_tmdb_search`        INT          NOT NULL,
    `title`                 VARCHAR(128) NOT NULL,
    `overview`           TEXT         NULL,
    `poster_path`           VARCHAR(128) NOT NULL,
    `release_date`          DATE         NULL,
    `id_tmdb_movie`         INT          NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tmdb_search_result`
    ADD CONSTRAINT `search_result` FOREIGN KEY IF NOT EXISTS (`id_tmdb_search`) REFERENCES `{tbl_prefix}tmdb_search` (`id_tmdb_search`) ON DELETE CASCADE ON UPDATE CASCADE;

SET @language_key = 'backdrop' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'backdrop', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'décor', @language_id_fra);

SET @language_key = 'poster' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'poster', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'affiche', @language_id_fra);

SET @language_key = 'thumbnail' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'thumbnail', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'vignette', @language_id_fra);

SET @language_key = 'default_x' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Default %s', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, '%s par défaut', @language_id_fra);

SET @language_key = 'option_require_x_enabled' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'This option require \'%s\' to be enabled', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Cette option nécessite que \'%s\' soit activé', @language_id_fra);

SET @language_key = 'select_as_default_x' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Select as default %s', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Sélectionner comme %s par défaut', @language_id_fra);

SET @language_key = 'enable_x_field' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Enable %s field', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Activer le champ %s', @language_id_fra);
