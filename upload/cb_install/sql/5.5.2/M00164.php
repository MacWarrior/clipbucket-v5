<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00164 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('please_login_to_flag', [
            'fr' => 'Veuillez vous connecter pour effectuer un signalement',
            'en' => 'Please login to flag'
        ]);

        self::generateTranslation('please_login', [
            'fr' => 'Veuillez vous connecter',
            'en' => 'Please login'
        ]);

        self::generateTranslation('report_text', [
            'fr'=>'Veuillez choisir la catégorie qui correspond le mieux à votre préoccupation concernant la vidéo, afin que nous puissions déterminer si elle est en violation avec notre charte de communauté ou n\'est pas approprié pour tous les utilisateurs. Tout abu de cette fonctionnalité est également une violation de notre charte de communauté, donc veuillez ne pas le faire.'
        ]);
    }

}
