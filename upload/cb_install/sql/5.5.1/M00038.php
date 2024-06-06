<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00038 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('enabled', [
            'fr' => 'activé',
            'en' => 'enabled'
        ]);

        self::generateTranslation('disabled', [
            'fr' => 'désactive',
            'en' => 'disabled'
        ]);

    }
}