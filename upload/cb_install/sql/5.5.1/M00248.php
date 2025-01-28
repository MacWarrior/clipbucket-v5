<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00248 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('share', [
            'fr' => 'Partager',
            'en' => 'Share'
        ]);
        self::generateTranslation('enable_link_sharing', [
            'fr'=>'Activer le partage par lien',
            'en'=>'Enable link sharing'
        ]);
        self::generateTranslation('enable_internal_sharing', [
            'fr'=>'Activer le partage en interne',
            'en'=>'Enable internal sharing'
        ]);

        self::generateConfig('enable_collection_link_sharing', 'yes');
        self::generateConfig('enable_collection_internal_sharing', 'yes');
    }
}