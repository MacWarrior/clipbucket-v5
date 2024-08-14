<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{

    const MIN_REVISION = '100';
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('tmdb_search') . ' ADD COLUMN list_years TEXT', [
            'table' => 'tmdb_search'
        ], [
            'table'  => 'tmdb_search',
            'column' => 'list_years'
        ]);
    }
}