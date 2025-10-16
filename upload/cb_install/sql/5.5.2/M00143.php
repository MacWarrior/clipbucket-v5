<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00143 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::updateTranslation('ai_setup_config', [
            'fr'=>'Veuillez activer l\'extension FFI (la configuration "preload" ne fonctionnera pas).',
            'en'=>'Please enable FFI extension ("preload" setting won\'t work).'
        ]);
    }

}
