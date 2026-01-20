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
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_element_type_new'
            ]
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}flags`
                            ADD CONSTRAINT `fk_id_flag_element_type_new` FOREIGN KEY (`id_flag_element_type`) REFERENCES `{tbl_prefix}object_type` (`id_object_type`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'flags',
            'column' => 'id_flag_element_type'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_element_type_new'
            ]
        ]);

        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}flag_element_type`';
        self::query($sql);

        $sql = 'ALTER TABLE `{tbl_prefix}favorites` ADD COLUMN `id_type` INT(11) NOT NULL AFTER `favorite_id`';
        self::alterTable($sql, [
            'table'  => 'favorites'
        ], [
            'table'  => 'favorites',
            'column' => 'id_type'
        ]);

        $sql = 'UPDATE `{tbl_prefix}favorites` SET `id_type` = (SELECT `id_object_type` FROM `{tbl_prefix}object_type` WHERE `name` = \'video\') WHERE type LIKE \'v\'';
        self::constrainedQuery($sql, [
            'table'=>'favorites',
            'column'=>'type'
        ]);
        $sql = 'UPDATE `{tbl_prefix}favorites` SET `id_type` = (SELECT `id_object_type` FROM `{tbl_prefix}object_type` WHERE `name` = \'photo\') WHERE type LIKE \'p\'';
        self::constrainedQuery($sql, [
            'table'=>'favorites',
            'column'=>'type'
        ]);
        $sql = 'UPDATE `{tbl_prefix}favorites` SET `id_type` = (SELECT `id_object_type` FROM `{tbl_prefix}object_type` WHERE `name` = \'collection\') WHERE type LIKE \'cl\'';
        self::constrainedQuery($sql, [
            'table'=>'favorites',
            'column'=>'type'
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}favorites`
                    ADD CONSTRAINT `fk_id_favorite_type` FOREIGN KEY (`id_type`) REFERENCES `{tbl_prefix}object_type` (`id_object_type`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'favorites',
            'column' => 'id_type'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_favorite_type'
            ]
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}favorites`
                    MODIFY COLUMN `userid` bigint(20) NOT NULL';
        self::alterTable($sql, [
            'table'  => 'favorites',
            'column' => 'userid'
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}favorites`
                    ADD CONSTRAINT `fk_favorites_userid` FOREIGN KEY (`userid`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'favorites',
            'column' => 'userid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_favorites_userid'
            ]
        ]);

        $sql = 'ALTER TABLE `{tbl_prefix}favorites` DROP COLUMN `type` ';
        self::alterTable($sql, [
            'table'  => 'favorites',
            'column' => 'type'
        ]);
    }
}
