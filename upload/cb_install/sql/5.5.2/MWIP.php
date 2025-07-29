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
        self::generateTranslation('option_enable_multi_factor_authentification', [
            'fr'=>'Authentification multifacteur',
            'en'=>'Multi Factor Authentification'
        ]);

        self::generateConfig('enable_multi_factor_authentification', 'allowed');

    }

}
