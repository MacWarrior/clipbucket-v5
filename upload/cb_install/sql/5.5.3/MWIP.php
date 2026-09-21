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
       self::generateTranslation('add_user', [
           'fr'=>'Ajouter un utilisateur',
           'en'=>'Add user'
       ]);
    }
}
