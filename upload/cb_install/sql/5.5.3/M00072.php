<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00072 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('confirmation_upgrade_core_breaking_version', [
            'fr' => 'Attention ! la version %s peut interrompre certaines fonctionnalités si la mise à jour n\'est pas complètement effectuée.',
            'en' => 'Warning ! version %s may break some functionalities if the update is not fully completed.'
        ]);

       
    }
}
