<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00342 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('completed', [
            'en' => 'Completed',
            'fr' => 'Terminé'
        ]);
    }
}