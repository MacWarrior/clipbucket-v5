<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00181 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::alterTable('ALTER TABLE ' . tbl('photos') . ' MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\' ON UPDATE CURRENT_TIMESTAMP;', [
           'table'=>'photos',
           'column'=>'last_viewed'
       ]);
       self::alterTable('ALTER TABLE ' . tbl('photos') . ' MODIFY COLUMN `server_url` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL;', [
           'table'=>'photos',
           'column'=>'server_url'
       ]);
       self::alterTable('ALTER TABLE ' . tbl('photos') . ' MODIFY COLUMN `photo_details` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL;', [
           'table'=>'photos',
           'column'=>'photo_details'
       ]);
    }
}
