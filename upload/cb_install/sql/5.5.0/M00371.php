<?php

namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00371 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`configid`, `name`, `value`)
                VALUES (NULL, \'tmdb_token\', \'\'),
                       (NULL, \'enable_tmdb\', \'no\'),
                       (NULL, \'tmdb_get_genre\', \'yes\'),
                       (NULL, \'tmdb_get_actors\', \'yes\'),
                       (NULL, \'tmdb_get_producer\', \'yes\'),
                       (NULL, \'tmdb_get_executive_producer\', \'yes\'),
                       (NULL, \'tmdb_get_director\', \'yes\'),
                       (NULL, \'tmdb_get_crew\', \'yes\'),
                       (NULL, \'tmdb_get_poster\', \'no\'),
                       (NULL, \'tmdb_get_release_date\', \'yes\'),
                       (NULL, \'tmdb_get_title\', \'yes\'),
                       (NULL, \'tmdb_get_description\', \'yes\'),
                       (NULL, \'tmdb_get_backdrop\', \'no\'),
                       (NULL, \'tmdb_get_age_restriction\', \'yes\'),
                       (NULL, \'enable_video_genre\', \'yes\'),
                       (NULL, \'enable_video_actor\', \'yes\'),
                       (NULL, \'enable_video_producer\', \'yes\'),
                       (NULL, \'enable_video_executive_producer\', \'yes\'),
                       (NULL, \'enable_video_director\', \'yes\'),
                       (NULL, \'enable_video_crew\', \'yes\'),
                       (NULL, \'enable_video_poster\', \'no\'),
                       (NULL, \'enable_video_backdrop\', \'no\'),
                       (NULL, \'tmdb_search\', \'10\');';
        self::query($sql);

        $sql = 'ALTER TABLE `{tbl_prefix}tags_type` ADD UNIQUE `name` (`name`);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tags_type` (name) VALUES (\'actors\'), (\'producer\'), (\'executive_producer\'), (\'director\'), (\'crew\'), (\'genre\');';
        self::query($sql);

        self::generateTranslation('enable_tmdb', [
            'en' => 'Enable TMDB',
            'fr' => 'Activer TMDB'
        ]);
        self::generateTranslation('tmdb_token', [
            'en' => 'TMDB authentification token',
            'fr' => 'Token d\'authentification TMDB'
        ]);
        self::generateTranslation('get_data_tmdb', [
            'en' => 'Get info from The Movie DataBase',
            'fr' => 'Récupérer les infos depuis The Movie DataBase'
        ]);
        self::generateTranslation('release_date', [
            'en' => 'Release date',
            'fr' => 'Date de sortie'
        ]);
        self::generateTranslation('import', [
            'en' => 'Import',
            'fr' => 'Importer'
        ]);
        self::generateTranslation('actors', [
            'en' => 'Actors',
            'fr' => 'Acteurs'
        ]);
        self::generateTranslation('producer', [
            'en' => 'Producer',
            'fr' => 'Producteur'
        ]);
        self::generateTranslation('crew', [
            'en' => 'Crew',
            'fr' => 'Equipe'
        ]);
        self::generateTranslation('genre', [
            'en' => 'Genre',
            'fr' => 'Genre'
        ]);
        self::generateTranslation('executive_producer', [
            'en' => 'Executive Producer',
            'fr' => 'Producteur exécutif'
        ]);
        self::generateTranslation('director', [
            'en' => 'Director',
            'fr' => 'Directeur'
        ]);
        self::generateTranslation('option_tmdb_get_genre', [
            'en' => 'Get genre from TMDB',
            'fr' => 'Récupérer le genre depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_actors', [
            'en' => 'Get actors from TMDB',
            'fr' => 'Récupérer les acteurs depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_producer', [
            'en' => 'Get producer from TMDB',
            'fr' => 'Récupérer le producteur depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_executive_producer', [
            'en' => 'Get executive producer from TMDB',
            'fr' => 'Récupérer le producteur exécutif depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_director', [
            'en' => 'Get director from TMDB',
            'fr' => 'Récupérer le directeur depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_director', [
            'en' => 'Get director from TMDB',
            'fr' => 'Récupérer le directeur depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_crew', [
            'en' => 'Get crew from TMDB',
            'fr' => 'Récupérer l\'équipe depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_poster', [
            'en' => 'Get poster from TMDB',
            'fr' => 'Récupérer l\'affiche depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_release_date', [
            'en' => 'Get release date from TMDB',
            'fr' => 'Récupérer la date de sortie depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_title', [
            'en' => 'Get title from TMDB',
            'fr' => 'Récupérer le titre depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_description', [
            'en' => 'Get description from TMDB',
            'fr' => 'Récupérer la description depuis TMDB'
        ]);
        self::generateTranslation('tmdb_search', [
            'en' => 'The Movie Database search',
            'fr' => 'Recherche The Movie Database'
        ]);
        self::generateTranslation('movie_infos', [
            'en' => 'Movie infos',
            'fr' => 'Informations sur le film'
        ]);
        self::generateTranslation('option_enable_video_poster', [
            'en' => 'Enable poster',
            'fr' => 'Activer les affiches'
        ]);
        self::generateTranslation('option_enable_video_backdrop', [
            'en' => 'Enable backdrop',
            'fr' => 'Activer les décors'
        ]);
        self::generateTranslation('option_tmdb_get_age_restriction', [
            'en' => 'Get age restriction from TMDB',
            'fr' => 'Récupérer la restriction d\'âge depuis TMDB'
        ]);
        self::generateTranslation('option_tmdb_get_backdrop', [
            'en' => 'Get backdrop from TMDB',
            'fr' => 'Récupérer le décors depuis TMDB'
        ]);
        self::generateTranslation('sort_by', [
            'en' => 'Sort by %s',
            'fr' => 'Trier par %s'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}video` ADD COLUMN `default_poster` INT(3) DEFAULT NULL;';
        self::alterTable($sql, [
            'table'  => 'video'
        ], [
            'table'  => 'video',
            'column' => 'default_poster'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}video` ADD COLUMN `default_backdrop` INT(3) DEFAULT NULL;';
        self::alterTable($sql, [
            'table'  => 'video'
        ], [
            'table'  => 'video',
            'column' => 'default_backdrop'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('tmdb_search') . '`
                (
                    `id_tmdb_search`  INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    `search_key`      VARCHAR(128) NOT NULL UNIQUE,
                    `datetime_search` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `total_results`   INT          NOT NULL
                ) ENGINE = InnoDB
                  DEFAULT CHARSET = utf8mb4
                  COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'CREATE TABLE IF NOT EXISTS `' . tbl('tmdb_search_result') . '`
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
                  COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'ALTER TABLE `' . tbl('tmdb_search_result') . '` ADD CONSTRAINT `search_result` FOREIGN KEY (`id_tmdb_search`) REFERENCES `' . tbl('tmdb_search') . '` (`id_tmdb_search`) ON DELETE CASCADE ON UPDATE CASCADE;';
        self::alterTable($sql, [
            'table'  => 'tmdb_search_result',
            'column' => 'id_tmdb_search'
        ], [
            'constraint_name'   => 'search_result',
            'constraint_type'   => 'FOREIGN KEY',
            'constraint_schema' => '{dbname}'
        ]);

        self::generateTranslation('backdrop', [
            'en' => 'backdrop',
            'fr' => 'décor'
        ]);
        self::generateTranslation('poster', [
            'en' => 'poster',
            'fr' => 'affiche'
        ]);
        self::generateTranslation('thumbnail', [
            'en' => 'thumbnail',
            'fr' => 'vignette'
        ]);
        self::generateTranslation('default_x', [
            'en' => 'Default %s',
            'fr' => '%s par défaut'
        ]);
        self::generateTranslation('option_require_x_enabled', [
            'en' => 'This option require \'%s\' to be enabled',
            'fr' => 'Cette option nécessite que \'%s\' soit activé'
        ]);
        self::generateTranslation('select_as_default_x', [
            'en' => 'Select as default %s',
            'fr' => 'Sélectionner comme %s par défaut'
        ]);
        self::generateTranslation('enable_x_field', [
            'en' => 'Enable %s field',
            'fr' => 'Activer le champ %s'
        ]);

    }
}