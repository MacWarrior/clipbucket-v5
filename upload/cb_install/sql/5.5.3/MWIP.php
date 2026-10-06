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
        self::generateTranslation('confirm_delete_users', [
            'fr'=>'Voulez-vous vraiment supprimer ces utilisateurs ?',
            'en'=>'Are you sure you want to delete these users ?'
        ]);
    }
}
