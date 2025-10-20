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
        self::generateTranslation('please_login_to_tag', [
            'fr'=>'	Veuillez vous connecter pour ajouter des mots clés',
            'en'=>'	'
        ]);
    }

}
