<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00078 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('launch_wip', [
            'fr'=>'Lancer la migration WIP',
            'en'=>'Launch WIP migration'
        ]);
    }
}
