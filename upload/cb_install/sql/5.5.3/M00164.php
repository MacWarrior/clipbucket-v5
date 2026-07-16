<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00164 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('invalid_params', [
           'fr'=>'Certains paramètres ne sont pas valides',
           'en'=>'Some parameters are invalid'
       ]);

    }
}
