<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
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

        self::generateTranslation('maintenance_recommended',[
            'fr'=>'Une mise en  maintenance est recommandée. Voulez-vous passer votre site en maintenance maintenant ?',
            'en'=>'Maintenance is recommended. Do you want to put your site in maintenance mode now ?'
        ]);

        self::generateTranslation('do_want_to_update',[
            'fr'=>'Voulez-vous continuer la mise à jour ?',
            'en'=>'Do you want to continue the update ?'
        ]);

        self::generateTranslation('website_closed', [
            'fr'=>'Le site a été correctement mis en maintenance',
            'en'=>'The website has been successfully put in maintenance'
        ]);
    }
}
