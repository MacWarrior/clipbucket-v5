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
    }

}
