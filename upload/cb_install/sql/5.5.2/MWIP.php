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

        self::generateConfig('enable_favorite_icon', 'no');

        self::generateTranslation('option_enable_favorite_icon', [
            'fr' => 'Utiliser l\'icône de favori',
            'en' => 'Use favorite icon'
        ]);

        self::generateTranslation('option_enable_favorite_icon_hint', [
            'fr' => 'Gérer le statut favoris via un icône près du titre de la vidéo',
            'en' => 'Manage favorite status with an icon near video title'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}categories_type` RENAME `{tbl_prefix}object_type`, RENAME COLUMN `id_category_type` TO `id_object_type` ', [
            'table' => 'categories_type',
            'column' => 'id_category_type'
        ], [
            'table' => 'object_type',
            'column' => 'id_object_type'
        ]);

        //replace cb_flag_element_type
        self::alterTable('ALTER TABLE `{tbl_prefix}flags` DROP FOREIGN KEY `fk_id_flag_element_type`', [
            'table' => 'flags',
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_element_type'
            ]
        ]);
        $sql = 'UPDATE `{tbl_prefix}flags` F 
                INNER JOIN `{tbl_prefix}flag_element_type` FET ON FET.`id_flag_element_type` = F.`id_flag_element_type`
                INNER JOIN `{tbl_prefix}object_type` OT ON OT.`name` = FET.`name`
                SET F.`id_flag_element_type` = OT.`id_object_type`';
        self::constrainedQuery($sql, [], [
            'table' => 'flags',
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_element_type'
            ]
        ]);
//        self::query($sql);
        $sql = 'ALTER TABLE `{tbl_prefix}flags`
                            ADD CONSTRAINT `fk_id_flag_element_type` FOREIGN KEY (`id_flag_element_type`) REFERENCES `{tbl_prefix}object_type` (`id_object_type`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'flags',
            'column' => 'id_flag_element_type'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_element_type'
            ]
        ]);

        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}flag_element_type`';
        self::query( $sql);
    }
}
