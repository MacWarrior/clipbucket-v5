<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00278 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('playlists') . ' DROP COLUMN tags', [
            'table'=>'playlists',
            'column'=>'tags',
        ] ,[]);
    }
}