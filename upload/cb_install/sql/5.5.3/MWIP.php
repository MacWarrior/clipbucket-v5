<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}languages` ADD COLUMN `language_flag` VARCHAR(4) NULL;', [
            'table' => 'languages',
        ], [
            'table' => 'languages',
            'column' => 'language_flag'
        ]);

        $sql = 'SELECT * FROM `{tbl_prefix}languages` L
         LEFT JOIN `{tbl_prefix}countries` C ON LOWER(L.language_code) = LOWER(C.iso2)
         WHERE `language_flag` IS NULL;';
        $languages = self::req($sql);
        foreach ($languages as $language) {
            $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'' . $language['iso2'] . '\' WHERE `language_id` = ' . $language['language_id'] . ';';
            self::query($sql);
        }

        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'pt\' WHERE `language_id` = (SELECT language_id FROM `{tbl_prefix}languages` WHERE `language_code` like \'pt-BR\' LIMIT 1) ;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'us\' WHERE `language_id` = (SELECT language_id FROM `{tbl_prefix}languages` WHERE `language_code` like \'en\' LIMIT 1) ;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'es\' WHERE `language_id` = (SELECT language_id FROM `{tbl_prefix}languages` WHERE `language_code` like \'esp\' LIMIT 1) ;';
        self::query($sql);

        self::generateConfig('display_language_flag', 'no');
        self::generateTranslation('lang_name_empty', [
            'fr'=>'Merci de renseigner le champs Nom de la langue'
        ]);
        self::generateTranslation('lang_code_empty', [
            'fr'=>'Merci de renseigner le champs Code de la langue'
        ]);
        self::generateTranslation('lang_flag_empty', [
            'fr'=>'Merci de renseigner le champs Drapeau de la langue',
            'en'=>'Please fill the language flag field'
        ]);
        self::generateTranslation('option_display_language_flag', [
            'fr'=>'Afficher le drapeau de la langue',
            'en'=>'Display language flag'
        ]);
    }
}
