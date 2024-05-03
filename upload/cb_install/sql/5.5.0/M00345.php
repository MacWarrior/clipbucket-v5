<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00345 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('mysql_client', [
            'en' => 'MySQL Client',
            'fr' => 'Client MySQL'
        ]);
        self::generateTranslation('mysql_server', [
            'en' => 'MySQL Server',
            'fr' => 'Serveur MySQL'
        ]);
    }
}