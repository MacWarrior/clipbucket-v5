<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00270 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}collection_contributors`;';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` DROP `voters`;', [
            'table' => 'comments',
            'column' => 'voters'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` DROP `vote`;', [
            'table' => 'comments',
            'column' => 'vote'
        ]);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'thanks_rating_comment\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'class_comment_err7\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'no_own_commen_rate\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'class_comment_err6\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'user_rate_comment\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
    }
}