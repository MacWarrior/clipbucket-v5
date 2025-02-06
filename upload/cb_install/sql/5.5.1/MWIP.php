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
        self::generateConfig('domain_url', get_server_url());

        self::generateTranslation('website_domain_url', [
            'fr'=>'URL du domaine',
            'en'=>'Domain URL'
        ]);

        self::generateTranslation('website_domain_url_hint', [
            'fr'=>'Indiquez l\'adresse de votre domaine',
            'en'=>'Specify your domain address'
        ]);
    }
}