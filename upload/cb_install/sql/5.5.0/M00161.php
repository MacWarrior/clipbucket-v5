<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00161 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        self::alterTable('ALTER TABLE `{tbl_prefix}languages` ADD COLUMN `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci;',[], [
            'table'  => 'languages',
            'column' => 'language_code',
        ]);

        $sql = 'UPDATE `{tbl_prefix}languages`
        SET `language_code`=language_id WHERE language_code IS NULL OR language_code = \'\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages` CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL UNIQUE;', [
            'table' => 'languages',
            'column' => 'language_code'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages_translations` MODIFY COLUMN `translation` VARCHAR(1024) NOT NULL;', [
            'table' => 'languages_translations',
            'column' => 'translation',
        ]);

        $sql = 'SET @language_id_eng = 1;';
        self::query($sql);
        $sql = 'SET @language_id_fra = 2;';
        self::query($sql);
        $sql = 'SET @language_id_deu = 3;';
        self::query($sql);
        $sql = 'SET @language_id_por = 4;';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'en\' WHERE language_id = @language_id_eng;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'fr\' WHERE language_id = @language_id_fra;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'de\' WHERE language_id = @language_id_deu;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'pt-BR\' WHERE language_id = @language_id_por;';
        self::query($sql);

        $sql = 'SET @language_key = \'code\' COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`) VALUES (@language_id_eng, @id_language_key, \'Code\');';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`) VALUES (@language_id_fra, @id_language_key, \'Code\');';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`) VALUES (@language_id_deu, @id_language_key, \'Code\');';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`) VALUES (@language_id_por, @id_language_key, \'Código\');';
        self::query($sql);

    }
}