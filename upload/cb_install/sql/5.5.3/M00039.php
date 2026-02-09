<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00039 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_favorite_icon_photo', 'no');
        self::generateConfig('enable_favorite_icon_collection', 'no');

        self::generateTranslation('option_enable_favorite_icon_hint_photo', [
            'fr'=>'Gérer le statut favoris via un icône près du titre de la photo',
            'en'=>'Manage favorite status with an icon near photo title'
        ]);

        self::generateTranslation('option_enable_favorite_icon_hint_collection', [
            'fr'=>'Gérer le statut favoris via un icône près du titre de la collection',
            'en'=>'Manage favorite status with an icon near collection title'
        ]);
    }
}
