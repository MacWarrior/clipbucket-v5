<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00244 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {

        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `blocked_countries`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'blocked_countries'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `sprite_count`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'sprite_count'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `failed_reason`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'failed_reason'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `category_parents`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'category_parents'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `featured_description`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'featured_description'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `aspect_ratio`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'aspect_ratio'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `files_thumbs_path`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'files_thumbs_path'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `unique_embed_code`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'unique_embed_code'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `refer_url`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'refer_url'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `server_ip`', [
            'table'  => '{tbl_prefix}video',
            'column' => 'server_ip'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP `process_status`', [
            'table'  => '{tbl_prefix}video',
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