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
        self::insertTool('install_missing_config', 'AdminTool::installMissingConfigs');

        self::insertTool('install_missing_translation', 'AdminTool::installMissingTranslations');

        self::generateTranslation('install_missing_config_label', [
            'fr' => 'Corriger les configurations manquantes',
            'en' => 'Fix missing configs'
        ]);

        self::generateTranslation('install_missing_config_description', [
            'fr' => 'Rejoue les scripts d\'installation pour corriger les configurations manquantes',
            'en' => 'Re-run install scripts to fix missing configs'
        ]);

        self::generateTranslation('install_missing_translation_label', [
            'fr' => 'Corriger les traductions manquantes',
            'en' => 'Fix missing translations'
        ]);

        self::generateTranslation('install_missing_translation_description', [
            'fr' => 'Rejoue les scripts d\'installation pour corriger les traductions manquantes',
            'en' => 'Re-run install scripts to fix missing translation'
        ]);

        self::generateTranslation('error_missing_config_please_use_tool', [
            'fr'=>'Il y a des configurations manquantes, veuillez utiliser l\'outil d\'installation en cliquant <a href="%s">ici</a>',
            'en'=>'There are missing configs, please use the installation tool by clicking <a href="%s">here</a>'
        ]);
        self::generateTranslation('error_missing_translation_please_use_tool', [
            'fr'=>'Il y a des traductions manquantes, veuillez utiliser l\'outil d\'installation en cliquant <a href="%s">ici</a>',
            'en'=>'There are missing translations, please use the installation tool by clicking <a href="%s">here</a>'
        ]);

        //get categ_type en doublon
        $sql = 'SELECT CONCAT(
                \'[\'
                ,GROUP_CONCAT(id_category_type ORDER BY id_category_type ASC SEPARATOR \',\')
                ,\']\'
            ) AS ids_list 
            FROM `{tbl_prefix}categories_type` 
            GROUP BY `name` HAVING COUNT(*) > 1;';
        $result = self::req($sql);
        //replace higher id by lower id
        if (!empty($result)) {
            foreach ($result as $item) {
                $item = json_decode($item['ids_list']);
                $orginal_id = $item[0];
                for ($i = 1; $i < count($item); $i++) {
                    $sql_update = 'UPDATE `{tbl_prefix}categories` SET `id_category_type` = ' . $orginal_id . ' WHERE `id_category_type` = ' . $item[$i] . ';';
                    self::query($sql_update);
                    //delete higher id
                    $sql_delete = 'DELETE FROM `{tbl_prefix}categories_type` WHERE `id_category_type` = ' . $item[$i] . ';';
                    self::query($sql_delete);
                }
            }
        }
        self::alterTable('ALTER TABLE `{tbl_prefix}categories_type` ADD CONSTRAINT name UNIQUE (`name`)', [
            'table'  => 'categories_type',
            'column' => 'name'
        ], [
            'constraint' => [
                'type'  => 'UNIQUE',
                'table' => 'categories_type',
                'name'  => 'name'
            ]
        ]);

        //get tools_histo_status en doublon
        $sql = 'SELECT CONCAT(
                \'[\'
                ,GROUP_CONCAT(id_tools_histo_status ORDER BY id_tools_histo_status ASC SEPARATOR \',\')
                ,\']\'
            ) AS ids_list 
            FROM `{tbl_prefix}tools_histo_status` 
            GROUP BY `language_key_title` HAVING COUNT(*) > 1;';
        $result = self::req($sql);
        //replace higher id by lower id
        if (!empty($result)) {
            foreach ($result as $item) {
                $item = json_decode($item['ids_list']);
                $orginal_id = $item[0];
                for ($i = 1; $i < count($item); $i++) {
                    $sql_update = 'UPDATE `{tbl_prefix}tools_histo` SET `id_tools_histo_status` = ' . $orginal_id . ' WHERE `id_tools_histo_status` = ' . $item[$i] . ';';
                    self::query($sql_update);
                    //delete higher id
                    $sql_delete = 'DELETE FROM `{tbl_prefix}tools_histo_status` WHERE `id_tools_histo_status` = ' . $item[$i] . ';';
                    self::query($sql_delete);
                }
            }
        }
        self::alterTable('ALTER TABLE `{tbl_prefix}tools_histo_status` ADD CONSTRAINT language_key_title UNIQUE (`language_key_title`)', [
            'table'  => 'tools_histo_status',
            'column' => 'language_key_title'
        ], [
            'constraint' => [
                'type'  => 'UNIQUE',
                'table' => 'tools_histo_status',
                'name'  => 'language_key_title'
            ]
        ]);

        //get categories en doublon
        $sql = 'SELECT CONCAT(
                    \'[\'
                   ,GROUP_CONCAT(JSON_OBJECT(\'category_id\',category_id, \'type\',CT.name)  ORDER BY category_id  ASC SEPARATOR \',\')
                   ,\']\'
               ) AS ids_list
                FROM `{tbl_prefix}categories` C
                         INNER JOIN `{tbl_prefix}categories_type` CT ON C.`id_category_type` = CT.`id_category_type`
                GROUP BY C.`id_category_type`,`category_name` HAVING COUNT(*) > 1';
        $result = self::req($sql);
        //replace higher id by lower id
        if (!empty($result)) {
            foreach ($result as $item) {
                $item = json_decode($item['ids_list'], true);
                $orginal_id = $item[0]['category_id'];
                for ($i = 1; $i < count($item); $i++) {
                    $id_category = $item[$i]['category_id'];
                    $sql_update = 'UPDATE IGNORE `{tbl_prefix}' . $item[$i]['type'] . 's_categories` SET `id_category` = ' . $orginal_id . ' WHERE `id_category` = ' . $id_category . ';';
                    self::query($sql_update);
                    //delete higher id
                    $sql_delete = 'DELETE FROM `{tbl_prefix}' . $item[$i]['type'] . 's_categories` WHERE `id_category` = ' . $id_category . ';';
                    self::query($sql_delete);
                    $sql_delete = 'DELETE FROM `{tbl_prefix}categories` WHERE `category_id` = ' . $id_category . ';';
                    self::query($sql_delete);
                }
            }
        }
        self::alterTable('ALTER TABLE `{tbl_prefix}categories` ADD CONSTRAINT category_name UNIQUE (`category_name`, `id_category_type`)', [
            'table'   => 'categories',
            'columns' => ['category_name', 'id_category_type']
        ], [
            'constraint' => [
                'type'  => 'UNIQUE',
                'table' => 'categories',
                'name'  => 'category_name'
            ]
        ]);
    }

}
