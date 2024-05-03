<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00084 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` MODIFY COLUMN `server_url` TEXT NULL DEFAULT NULL, MODIFY COLUMN `photo_details` TEXT NULL DEFAULT NULL; ', [
            'table'   => 'photos',
            'columns' => [
                'server_url',
                'photo_details'
            ]
        ]);
    }
}