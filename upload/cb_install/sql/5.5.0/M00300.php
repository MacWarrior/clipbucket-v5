<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00300 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('confirm', [
            'en'    => 'Confirm',
            'fr'    => 'Confirmer',
            'de'    => 'Bestätigen Sie',
            'pt-BR' => 'Confirmar'
        ]);
    }
}