<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00138 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('at_least_one_resolution', [
            'fr'=>'Au moins une résolution doit être activée',
            'en'=>'At least one resolution must be enabled'
        ]);
    }

}
