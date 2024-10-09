<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00164 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('force_to_error', [
           'fr'=>'Forcer en erreur',
           'en'=>'Force to error'
       ]);

       self::generateTranslation('tool_forced_to_error', [
           'fr'=>'Outil forcé en erreur',
           'en'=>'Tool forced to error'
       ]);

    }
}
