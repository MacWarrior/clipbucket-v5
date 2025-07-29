<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('usr_attach_video', [
            'fr'=>'Joindre une vidéo'
        ]);

        self::generateTranslation('no_video', [
            'fr'=>'Pas de vidéo'
        ]);

        self::generateTranslation('user_send_message', [
            'fr'=>'Envoyer un message'
        ]);

        self::generateTranslation('write_msg', [
            'fr'=>'Écrire un message'
        ]);

        self::generateTranslation('you_cant_send_pm_yourself', [
            'fr'=>'Vous ne pouvez pas vous envoyer de message à vous même.'
        ]);

        self::generateTranslation('running_verification', [
            'fr'=>'Vérification en cours',
            'en'=>'Running verification'
        ]);

        self::generateTranslation('checked_user', [
            'fr'=>'Utilisateur vérifié',
            'en'=>'Checked user'
        ]);

        self::generateTranslation('user_no_exist_wid_username', [
            'fr'=>'L\'utilisateur \'%s\' n\'existe pas'
        ]);
        self::updateTranslation('user_no_exist_wid_username', [
            'en'=>'User %s does not exist'
        ]);
    }

}
