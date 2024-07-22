<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00074 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('core_updating', [
            'fr' => 'Mise à jour du coeur en cours...',
            'en' => 'Core update ongoing...'
        ]);
        self::generateTranslation('db_updating', [
            'fr'=>'Mise à jour BDD en cours...',
            'en'=>'Database update ongoing...'
        ]);
    }
}
