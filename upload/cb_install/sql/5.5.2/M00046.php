<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00046 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('reconversion_started_for_x', [
            'fr'=>'La reconversion de %s a été lancée',
            'en'=>'Reconversion for %s has been launched'
        ]);
    }
}
