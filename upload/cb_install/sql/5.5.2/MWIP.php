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
        self::updateTranslation('warning_ai_requirements', [
            'fr'=>'Les fonctionnalités IA nécessitent l\'extension FFI'
            ,'en'=>'AI features require FFI extension'
        ]);
    }

}
