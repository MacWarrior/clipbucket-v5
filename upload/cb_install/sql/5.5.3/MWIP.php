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
            'fr'=>'Voulez vous activer la maintenance pendant cette mise à jour',
            'en'=>'Do you want to enable maintenance mode during this update ?'
        ]);

        self::generateTranslation('do_want_to_update',[
            'fr'=>'Voulez-vous vraiment effectuer la mise à jour maintenant ?',
            'en'=>'Do you really want to update now ?'
        ]);

        self::generateTranslation('website_closed', [
            'fr'=>'Le site a été correctement mis en maintenance',
            'en'=>'The website has been successfully put in maintenance'
        ]);

        self::generateTranslation('update_completed_maintenance_off', [
            'fr'=>'La mise à jour est terminée. Le mode maintenance a été désactivé.',
            'en'=>'Update has been completed, maintenance mode has been disabled'
        ]);

        self::generateTranslation('update_incomplete', [
            'fr'=>'Attention ! Quelque chose s\'est mal passé pendant la mise à jour, veuillez vérifier votre configuration et vous assurer que votre base de données est entièrement à jour',
            'en'=>'Warning ! Something went wrong during update, please check your setup and make sure your DB is fully updated'
        ]);

        self::generateTranslation('maintenance_still_on', [
            'fr'=>'Le mode maintenance est resté activé.',
            'en'=>'Maintenance mode has been kept enabled.'
        ]);

        self::generateTranslation('ok', [
            'fr'=>'OK',
            'en'=>'OK'
        ]);
    }
}
