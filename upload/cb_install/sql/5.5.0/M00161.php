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
        self::alterTable('ALTER TABLE `{tbl_prefix}languages` ADD COLUMN `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci;', [
            'table'  => 'languages'
        ], [
            'table'  => 'languages',
            'column' => 'language_code'
        ]);

        $sql = 'UPDATE `{tbl_prefix}languages`
        SET `language_code`=language_id WHERE language_code IS NULL OR language_code = \'\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages` CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL UNIQUE;', [
            'table' => 'languages',
            'column' => 'language_code'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}languages_translations` MODIFY COLUMN `translation` VARCHAR(1024) NOT NULL;', [
            'table' => 'languages_translations',
            'column' => 'translation'
        ]);

        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'en\' WHERE language_id = 1;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'fr\' WHERE language_id = 2;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'de\' WHERE language_id = 3;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_code`=\'pt-BR\' WHERE language_id = 4;';
        self::query($sql);

        self::generateTranslation('code', [
            'fr' => 'Code',
            'en' => 'Code',
            'de' => 'Code',
            'pt-BR' => 'Código'
        ]);
    }
}