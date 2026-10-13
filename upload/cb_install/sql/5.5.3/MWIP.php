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
        self::generateTranslation('sub_item_featured', [
            'fr'=>'Sous-éléments en vedette',
            'en'=>'Featured sub-items'
        ]);

        self::generateTranslation('display_collection_sub_item_featured_hint', [
            'fr'=>'Affiche les éléments des sous-collections quand elle est mise en vedette',
            'en'=>'Show sub-collections items when featured'
        ]);

        self::generateTranslation('sub_collection_featured', [
            'fr'=>'Sous-collections en vedette',
            'en'=>'Featured sub-collections'
        ]);

        self::generateTranslation('display_collection_sub_collection_featured_hint', [
            'fr'=>'Affiche les sous-collections quand elle est mise en vedette',
            'en'=>'Show sub-collections when featured'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD COLUMN `sub_item_featured` ENUM(\'yes\', \'no\') DEFAULT \'no\' AFTER hierarchy_featured', [], [
            'table'  => 'collections',
            'column' => 'sub_item_featured'
        ]);
        self::query('UPDATE `{tbl_prefix}collections` SET `sub_item_featured` = \'yes\'');

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD COLUMN `sub_collection_featured` ENUM(\'yes\', \'no\') DEFAULT \'no\' AFTER hierarchy_featured', [], [
            'table'  => 'collections',
            'column' => 'sub_collection_featured'
        ]);
    }
}
