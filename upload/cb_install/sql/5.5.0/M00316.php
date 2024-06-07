<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00316 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('dev_mode', [
            'en' => 'Development mode',
            'fr' => 'Mode développement'
        ]);

        self::generateTranslation('dev', [
            'en' => 'Dev',
            'fr' => 'Dev'
        ]);
    }
}