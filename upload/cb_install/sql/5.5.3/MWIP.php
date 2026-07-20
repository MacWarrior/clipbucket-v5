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
            'table'  => 'languages',
            'column' => 'language_flag'
        ]);

        self::query('CREATE TABLE IF NOT EXISTS `{tbl_prefix}pages_translations` (
            `page_id` INT(11) NOT NULL,
            `language_id` INT(9) NOT NULL,
            `page_title` VARCHAR(225) NOT NULL,
            `page_content` TEXT NOT NULL,
            PRIMARY KEY (`page_id`, `language_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;');

        self::alterTable('ALTER TABLE `{tbl_prefix}pages_translations` ADD CONSTRAINT `pages_translations_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `{tbl_prefix}pages` (`page_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'pages_translations',
            'column' => 'page_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'pages_translations_ibfk_1',
            ]
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}pages_translations` ADD CONSTRAINT `pages_translations_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'pages_translations',
            'column' => 'page_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'pages_translations_ibfk_2',
            ]
        ]);

        $sql = 'SELECT * FROM `{tbl_prefix}languages` L
         LEFT JOIN `{tbl_prefix}countries` C ON LOWER(L.language_code) = LOWER(C.iso2)
         WHERE `language_flag` IS NULL;';
        $languages = self::req($sql);
        foreach ($languages as $language) {
            $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'' . strtolower($language['iso2']) . '\' WHERE `language_id` = ' . $language['language_id'] . ';';
            self::query($sql);
            if ($language['language_default'] == 'yes') {
                $pages = \cbpage::getInstance()->get_pages();
                foreach ($pages as $page) {
                    $sql = 'INSERT IGNORE INTO `{tbl_prefix}pages_translations` (`page_id`, `language_id`, `page_title` ,`page_content`) VALUES (' . mysql_clean($page['page_id']) . ', ' . mysql_clean($language['language_id']) . ', \'' . mysql_clean($page['page_title']) . '\', \'' . mysql_clean($page['page_content']) . '\')';
                    self::query($sql);
                }
            }
        }

        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'pt\' WHERE `language_id` = (SELECT language_id FROM `{tbl_prefix}languages` WHERE `language_code` LIKE \'pt-BR\' LIMIT 1) ;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'us\' WHERE `language_id` = (SELECT language_id FROM `{tbl_prefix}languages` WHERE `language_code` LIKE \'en\' LIMIT 1) ;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_flag` = \'es\' WHERE `language_id` = (SELECT language_id FROM `{tbl_prefix}languages` WHERE `language_code` LIKE \'esp\' LIMIT 1) ;';
        self::query($sql);

        self::generateConfig('display_language_flag', 'no');
        self::generateTranslation('lang_name_empty', [
            'fr' => 'Merci de renseigner le champs Nom de la langue'
        ]);
        self::generateTranslation('lang_code_empty', [
            'fr' => 'Merci de renseigner le champs Code de la langue'
        ]);
        self::generateTranslation('lang_flag_empty', [
            'fr' => 'Merci de renseigner le champs Drapeau de la langue',
            'en' => 'Please fill the language flag field'
        ]);
        self::generateTranslation('option_display_language_flag', [
            'fr' => 'Afficher le drapeau de la langue',
            'en' => 'Display language flag'
        ]);
        self::generateTranslation('edit_page_translation', [
            'fr' => 'Éditer la traduction : %s',
            'en' => 'Edit translation : %s'
        ]);
        self::generateTranslation('no_specified', [
            'fr' => 'Non renseigné',
            'en' => 'Not specified'
        ]);
        self::generateTranslation('specified', [
            'fr' => 'Renseigné',
            'en' => 'Specified'
        ]);
        self::generateTranslation('new_page', [
            'fr'=>'Créer une nouvelle page',
            'en'=>'Create a new page'
        ]);
        self::generateTranslation('update_page', [
            'fr'=>'Mettre à jour la page',
            'en'=>'Update page'
        ]);
        self::generateTranslation('add_new_page', [
            'fr'=>'Ajouter une nouvelle page',
            'en'=>'Add new page'
        ]);
        self::generateTranslation('edit_page', [
            'fr'=>'Modifier la page',
            'en'=>'Edit page'
        ]);
        self::generateTranslation('translations', [
            'fr'=>'Traductions',
            'en'=>'Translations'
        ]);
    }
}
