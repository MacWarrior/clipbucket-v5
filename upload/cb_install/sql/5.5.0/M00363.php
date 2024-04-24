<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00363 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `video_users` TEXT NULL DEFAULT NULL;', [
            'table'  => '{tbl_prefix}video',
            'column' => 'video_users'
        ]);
    }
}