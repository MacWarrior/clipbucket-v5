<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable("ALTER TABLE `{tbl_prefix}tmdb_search` MODIFY COLUMN `type` ENUM('movie', 'series', 'season', 'episode') NOT NULL DEFAULT 'movie'", [
            'table' => 'tmdb_search',
            'column' => 'type'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}tmdb_search` ADD COLUMN `navigation_title` VARCHAR(512) NULL', [
            'table' => 'tmdb_search'
        ], [
            'table' => 'tmdb_search',
            'column' => 'navigation_title'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}tmdb_search_result` ADD COLUMN `season_number` INT NULL', [
            'table' => 'tmdb_search_result'
        ], [
            'table' => 'tmdb_search_result',
            'column' => 'season_number'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}tmdb_search_result` ADD COLUMN `episode_number` INT NULL', [
            'table' => 'tmdb_search_result'
        ], [
            'table' => 'tmdb_search_result',
            'column' => 'episode_number'
        ]);

        self::generateTranslation('tmdb_choose', [
            'fr' => 'Sélectionner',
            'en' => 'Choose'
        ]);
        self::generateTranslation('tmdb_back', [
            'fr' => 'Retour',
            'en' => 'Back'
        ]);
        self::generateTranslation('tmdb_season', [
            'fr' => 'Saison',
            'en' => 'Season'
        ]);
        self::generateTranslation('tmdb_episode', [
            'fr' => 'Épisode',
            'en' => 'Episode'
        ]);
        self::generateTranslation('tmdb_new_search_confirm', [
            'fr' => 'Si vous lancez une nouvelle recherche, la sélection en cours sera perdue. Souhaitez-vous continuer ?',
            'en' => 'If you start a new search, current selection will be lost. Do you want to continue ?'
        ]);
        self::generateTranslation('tmdb_dont_ask_again', [
            'fr' => 'Ne plus demander',
            'en' => 'Don\'t ask again'
        ]);

        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_tmdb` (
            collection_id BIGINT(25) NOT NULL PRIMARY KEY,
            tmdb_id INT NOT NULL,
            tmdb_type VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;', [], [
            'table' => 'collection_tmdb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collection_tmdb` ADD CONSTRAINT `tmdb_collection_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;', [
            'table'  => 'collection_tmdb',
            'column' => 'collection_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'tmdb_collection_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD COLUMN `external_rate` FLOAT NOT NULL DEFAULT 0', [
            'table' => 'collections'
        ], [
            'table'  => 'collections',
            'column' => 'external_rate'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD COLUMN `external_ratings` INT NOT NULL DEFAULT 0', [
            'table' => 'collections'
        ], [
            'table'  => 'collections',
            'column' => 'external_ratings'
        ]);
    }
}
