<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00163 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_thumbs`(
            `videoid`    BIGINT(20)  NOT NULL,
            `resolution` VARCHAR(16) NOT NULL,
            `num`        VARCHAR(4)  NOT NULL,
            `extension`  VARCHAR(4)  NOT NULL,
            `version`    VARCHAR(30) NOT NULL,
            PRIMARY KEY `resolution` (`videoid`, `resolution`, `num`),
            KEY `videoid` (`videoid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_thumbs` ADD CONSTRAINT `video_thumbs_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;', [
            'table' => 'video_thumbs',
            'column'         => 'videoid'
            ],[
            'constraint_name' => 'video_thumbs_ibfk_1',
            'contraint_type' => 'FOREIGN KEY'
        ]);
    }
}