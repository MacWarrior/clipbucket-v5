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
        self::generateTranslation('request_has_been_canceled', [
            'fr'=>'Votre demande d\'ami a été annulée',
            'en'=>'Your request has been canceled'
        ]);

        self::generateTranslation('confirm_unfriend', [
            'fr'=>'Voulez-vous vraiment supprimer %s de votre liste des contacts ?',
            'en'=>'Are you sure you want to unfriend %s ?'
        ]);
    }
}
