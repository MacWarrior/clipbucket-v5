<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00363 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `video_users` TEXT NULL DEFAULT NULL;', [
            'table' => 'video',
            'column' => 'video_users'
        ]);
    }
}