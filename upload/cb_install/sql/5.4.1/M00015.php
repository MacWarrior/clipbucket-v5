<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00015 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video`
            MODIFY COLUMN `videokey` MEDIUMTEXT NULL DEFAULT NULL,
            MODIFY COLUMN `video_password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `video_users` TEXT NOT NULL,
            MODIFY COLUMN `userid` INT(11) NULL DEFAULT NULL,
            MODIFY COLUMN `file_name` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `tags` MEDIUMTEXT NULL DEFAULT NULL,
            MODIFY COLUMN `uploader_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `file_directory` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\';', [
            'table'   => 'video',
            'columns' => [
                'videokey',
                'video_password',
                'video_users',
                'userid',
                'file_name',
                'tags',
                'uploader_ip',
                'file_directory'
            ]
        ]);
    }
}