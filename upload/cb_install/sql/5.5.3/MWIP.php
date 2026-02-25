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
        self::generateConfig('enable_featured_collection_hierarchy', 'yes');

        self::generateTranslation('option_enable_featured_collection_hierarchy', [
            'fr' => 'Activer la hiérarchie pour les collections mises en vedette',
            'en' => 'Enable featured collection hierarchy',
        ]);

        self::generateTranslation('display_collection_hierarchy_featured_hint', [
            'fr' => 'Afficher la hiérarchie d\'une collection quand elle est mise en vedette',
            'en' => 'Display collection hierarchy when it is featured'
        ]);

        self::generateTranslation('hierarchy_featured', [
            'fr' => 'Hiérarchie en vedette',
            'en' => 'Featured hierarchy'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD COLUMN `hierarchy_featured` ENUM(\'yes\', \'no\') DEFAULT \'no\' AFTER featured', [], [
            'table'  => 'collections',
            'column' => 'hierarchy_featured'
        ]);
    }
}
