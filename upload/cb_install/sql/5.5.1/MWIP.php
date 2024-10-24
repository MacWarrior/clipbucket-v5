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
       self::generateTranslation('wip_done', [
           'fr'=>'Migration WIP effectuée avec succès',
           'en'=>'WIP migration done succesfully'
       ]);
       self::generateTranslation('relaunch', [
           'fr'=>'Relancer',
           'en'=>'Relaunch'
       ]);
    }
}
