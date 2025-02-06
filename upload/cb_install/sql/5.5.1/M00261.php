<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00261 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        if( function_exists('get_server_url') ){
            $server_url = get_server_url();
        } else {
            $server_url = \Network::get_server_url();
        }
        self::generateConfig('base_url', $server_url);

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