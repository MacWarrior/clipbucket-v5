<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_image` (
            id_video_image INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            videoid BIGINT(20) NOT NULL,
            type ENUM(\'thumbnail\',\'poster\', \'backdrop\') NOT NULL,
            num INT NOT NULL,
            is_auto BOOL DEFAULT TRUE NOT NULL,
            UNIQUE KEY (videoid, type, num)
        );';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_image` ADD CONSTRAINT `video_image_ibfk_1` FOREIGN KEY (videoid) REFERENCES `{tbl_prefix}video` (videoid);', [
            'table'  => 'video',
            'column' => 'videoid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_image_ibfk_1'
            ]
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_thumb` (
            id_video_thumb INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_video_image INT NOT NULL,
            width INT NOT NULL,
            height INT NOT NULL,
            extension VARCHAR(4) NOT NULL,
            version VARCHAR(16) NOT NULL,
            UNIQUE KEY (id_video_image, width, height)
        );';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_thumb` ADD CONSTRAINT `video_thumb_ibfk_1` FOREIGN KEY (id_video_image) REFERENCES `{tbl_prefix}video_image` (id_video_image);', [
            'table'  => 'video_image',
            'column' => 'id_video_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_thumb_ibfk_1'
            ]
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_thumb` (
            id_photo_thumb INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            photo_id BIGINT(255) NOT NULL,
            width INT NOT NULL,
            height INT NOT NULL,
            extension VARCHAR(4) NOT NULL,
            version VARCHAR(16) NOT NULL,
            UNIQUE KEY (photo_id, width, height)
        );';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}photo_thumb` ADD CONSTRAINT `photo_thumb_ibfk_1` FOREIGN KEY (photo_id) REFERENCES `{tbl_prefix}photos` (photo_id);', [
            'table'  => 'photos',
            'column' => 'photo_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'photo_thumb_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `default_thumb` INT ', [
            'table'  => 'video'
        ], [
            'table'  => 'video',
            'column' => 'default_thumb'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `default_poster` INT ', [
            'table'  => 'video'
        ], [
            'table'  => 'video',
            'column' => 'default_poster'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `default_backdrop` INT ', ['table'  => 'video'], ['table'  => 'video', 'column' => 'default_backdrop']);

        //TODO migrer les thumbs


        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}video_thumb`';
//        self::query($sql);
//        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `video_thumbs`');
    }

}
