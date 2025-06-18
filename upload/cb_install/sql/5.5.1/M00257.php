<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00257 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('video') . ' MODIFY COLUMN `uploader_ip` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'\';', [
            'table'  => 'video',
            'column' => 'uploader_ip'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('photos') . ' MODIFY COLUMN `owner_ip` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'\';', [
            'table'  => 'photos',
            'column' => 'owner_ip'
        ]);

    }
}
