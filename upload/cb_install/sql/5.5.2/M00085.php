<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00085 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('my_collections', [
            'fr'=>'Mes collections',
            'en'=>'My collections'
        ]);

        self::generateTranslation('my_friends_collections', [
            'fr'=>'Les collections de mes amis',
            'en'=>'My friends collections'
        ]);

        self::generateTranslation('public_collections', [
            'fr'=>'Autres collections publiques',
            'en'=>'Other public collections'
        ]);
    }

}
