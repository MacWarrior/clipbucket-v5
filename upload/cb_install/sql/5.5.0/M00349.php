<?php

namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00349 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'ALTER TABLE `{tbl_prefix}video_subtitle` DROP FOREIGN KEY `video_subtitle_ibfk_1`';
        self::alterTable($sql, [
            'table'           => 'video_subtitle',
            'constraint_name' => 'video_subtitle_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}video_subtitle` ADD CONSTRAINT `video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video`(`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;';
        self::alterTable($sql, [
            'table'  => 'video_subtitle',
            'column' => 'videoid'
        ], [
            'constraint_name'  => 'video_subtitle_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}languages_translations` DROP FOREIGN KEY `languages_translations_ibfk_1`';
        self::alterTable($sql, [
            'table'           => 'languages_translations',
            'constraint_name' => 'languages_translations_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}languages_translations` DROP FOREIGN KEY `languages_translations_ibfk_2`';
        self::alterTable($sql, [
            'table'           => 'languages_translations',
            'constraint_name' => 'languages_translations_ibfk_2',
            'constraint_type' => 'FOREIGN KEY'
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}languages_translations` ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;';
        self::alterTable($sql, [
            'table'  => 'languages_translations',
            'column' => 'language_id'
        ], [
            'constraint_name'  => 'languages_translations_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}languages_translations` ADD CONSTRAINT `languages_translations_ibfk_2` FOREIGN KEY (`id_language_key`) REFERENCES `{tbl_prefix}languages_keys` (`id_language_key`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'languages_translations',
            'column' => 'id_language_key'
        ], [
            'constraint_name'  => 'languages_translations_ibfk_2',
            'constraint_type' => 'FOREIGN KEY'
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}video_thumbs` DROP FOREIGN KEY `video_thumbs_ibfk_1`';
        self::alterTable($sql, [
            'table'           => 'video_thumbs',
            'constraint_name' => 'video_thumbs_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}video_thumbs` ADD CONSTRAINT `video_thumbs_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;';
        self::alterTable($sql, [
            'table'  => 'video_thumbs',
            'column' => 'videoid'
        ], [
            'constraint_name'  => 'video_thumbs_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);
    }
}