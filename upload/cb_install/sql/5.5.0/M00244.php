<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00244 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `blocked_countries`', [
            'table' => 'video',
            'column' => 'blocked_countries'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `sprite_count`', [
            'table' => 'video',
            'column' => 'sprite_count'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `failed_reason`', [
            'table' => 'video',
            'column' => 'failed_reason'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `category_parents`', [
            'table' => 'video',
            'column' => 'category_parents'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `featured_description`', [
            'table' => 'video',
            'column' => 'featured_description'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `aspect_ratio`', [
            'table' => 'video',
            'column' => 'aspect_ratio'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `files_thumbs_path`', [
            'table' => 'video',
            'column' => 'files_thumbs_path'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `unique_embed_code`', [
            'table' => 'video',
            'column' => 'unique_embed_code'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `refer_url`', [
            'table' => 'video',
            'column' => 'refer_url'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `server_ip`', [
            'table' => 'video',
            'column' => 'server_ip'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `process_status`', [
            'table' => 'video',
            'column' => 'process_status'
        ]);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'grab_from_youtube\');';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'youtube_api_key\';';
        self::query($sql);
    }
}