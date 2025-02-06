<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('base_url', get_server_url());

        self::generateTranslation('website_base_url', [
            'fr'=>'URL de base',
            'en'=>'Base URL'
        ]);

        self::generateTranslation('website_base_url_hint', [
            'fr'=>'Indiquez l\'adresse de votre domaine',
            'en'=>'Specify your domain address'
        ]);
    }
}