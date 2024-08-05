<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00040 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('cloudflare_documentation', [
            'fr' => 'Documentation Cloudflare',
            'en' => 'Cloudflare documentation'
        ]);

        self::generateTranslation('incorrect_configuration_413_error', [
            'fr' => 'Une configuration incorrecte pourrait causer des erreurs 413.',
            'en' => 'Incorrect configuration might cause 413 errors.'
        ]);

    }
}