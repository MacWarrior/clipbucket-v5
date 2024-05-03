<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00008 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN filegrp_size', [
            'table' => 'video',
            'column' => 'filegrp_size'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN file_thumbs_count', [
            'table' => 'video',
            'column' => 'file_thumbs_count'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN conv_progress', [
            'table' => 'video',
            'column' => 'conv_progress'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN is_hd', [
            'table' => 'video',
            'column' => 'is_hd'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN has_hd', [
            'table' => 'video',
            'column' => 'has_hd'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN has_mobile', [
            'table' => 'video',
            'column' => 'has_mobile'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN has_hq', [
            'table' => 'video',
            'column' => 'has_hq'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN extras', [
            'table' => 'video',
            'column' => 'extras'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN mass_embed_status', [
            'table' => 'video',
            'column' => 'mass_embed_status'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT \'5.5.0\'', [
            'table' => 'video',
            'column' => 'video_version'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `thumbs_version` varchar(30) NOT NULL DEFAULT \'5.5.0\'', [
            'table' => 'video',
            'column' => 'thumbs_version'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `file_type` varchar(30) NOT NULL DEFAULT \'5.5.0\'', [
            'table' => 'video',
            'column' => 'file_type'
        ]);
    }
}