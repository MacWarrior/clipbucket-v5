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
        self::generateConfig('max_photo_categories', 0);
        self::generateConfig('max_collection_categories', 0);

        self::generateTranslation('option_max_photo_categories', [
            'fr'=>'Catégories maximum',
            'en'=>'Max categories'
        ]);
        self::generateTranslation('option_max_photo_categories_hint', [
            'fr'=>'Nombre maximum de catégories par photo ; 0 pour aucune limite',
            'en'=>'Maximum categories per photo ; 0 for unlimited'
        ]);
        self::generateTranslation('option_max_collection_categories', [
            'fr'=>'Catégories maximum',
            'en'=>'Max categories'
        ]);
        self::generateTranslation('option_max_collection_categories_hint', [
            'fr'=>'Nombre maximum de catégories par collection ; 0 pour aucune limite',
            'en'=>'Maximum categories per collection ; 0 for unlimited'
        ]);
    }

}
