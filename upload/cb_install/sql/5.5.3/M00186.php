<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00186 extends \Migration
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
       self::generateTranslation('here', [
           'fr'=>'ici',
           'en'=>'here'
       ]);
       self::generateTranslation('default_homepage_cannot_be_empty', [
           'fr'=>'La page d\'accueil par défaut ne peut pas etre vide',
           'en'=>'Default homepage cannot be empty'
       ]);
       self::generateTranslation('add_user_level', [
           'fr'=>'Ajouter un niveau d\'utilisateur',
           'en'=>'Add user level'
       ]);
    }
}
