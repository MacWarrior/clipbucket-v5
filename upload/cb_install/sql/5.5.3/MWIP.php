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
       self::generateTranslation('empty_homepage', [
           'fr'=>'Certains niveaux d’utilisateurs sont configurés avec une page d’accueil par défaut vide, cliquez %s pour mettre à jour les niveaux d’utilisateurs',
           'en'=>'Some user levels are configured with an empty default homepage, click %s to update user levels'
       ]);
       self::generateTranslation('disabled_homepage', [
           'fr'=>'Certains niveaux d’utilisateurs sont configurés avec une page d’accueil par défaut désactivée, cliquez %s pour mettre à jour les niveaux d’utilisateurs',
           'en'=>'Some user levels are configured with a disabled page as homepage, click %s to update user levels'
       ]);
    }
}
