<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('collection_not_found', [
            'fr' => 'Une collection est nécessaire pour compléter la configuration de la photo',
            'en'=>'A collection is requiered to complete photo configuration'
        ]);

    }
}
