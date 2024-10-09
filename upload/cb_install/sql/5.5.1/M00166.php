<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00166 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('user_level', [
            'fr' => 'Niveau d\'utilisateur',
            'en' => 'User level'
        ]);

        self::generateTranslation('administrator', [
            'fr'=>'Administrateur',
            'en'=>'Administrator'
        ]);
        self::generateTranslation('registered_user', [
            'fr'=>'Utilisateur enregistré',
            'en'=>'Registered user'
        ]);

        self::generateTranslation('inactive_user', [
            'fr'=>'Utilisateur inactif',
            'en'=>'Inactive user'
        ]);

        self::generateTranslation('global_moderator', [
            'fr'=>'Modérateur global',
            'en'=>'Global moderator'
        ]);
    }
}
