<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00372 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('unknown_type', [
            'en' => 'Unknown type : %s',
            'fr' => 'Type inconnu : %s'
        ]);
    }
}