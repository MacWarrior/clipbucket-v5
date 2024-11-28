<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'ALTER TABLE ' . tbl('tmdb_search')
            . ' ADD COLUMN `type` ENUM (\'movie\', \'series\') NOT NULL DEFAULT \'movie\' ';
        self::alterTable($sql
            , ['table' => 'tmdb_search']
            , [
                'table'  => 'tmdb_search',
                'column' => 'type'
            ]
        );
        $sql = 'ALTER TABLE ' . tbl('tmdb_search')
            . ' ADD COLUMN `language` VARCHAR(20) NOT NULL DEFAULT \'en\'';
        self::alterTable($sql
            , ['table' => 'tmdb_search']
            , [
                'table'  => 'tmdb_search',
                'column' => 'language'
            ]
        );

        $sql = 'ALTER TABLE ' . tbl('tmdb_search') . ' DROP INDEX `search_key`';
        self::alterTable($sql, [
                'constraint_type'  => 'UNIQUE',
                'constraint_name'  => 'search_key'
        ]);
        $sql = 'ALTER TABLE ' . tbl('tmdb_search') . ' ADD UNIQUE INDEX unique_search_key (`search_key`, `type`, `language`)';
        self::alterTable($sql, [
            'table'   => 'tmdb_search',
            'columns' => [
                'search_key',
                'type',
                'language'
            ]
        ], [
            'constraint_type'  => 'UNIQUE',
            'constraint_name'  => 'unique_search_key'
        ]);

        self::generateTranslation('movie', [
            'fr' => 'Film',
            'en' => 'Movie'
        ]);
        self::generateTranslation('series', [
            'fr' => 'Série',
            'en' => 'TV Show'
        ]);
    }
}