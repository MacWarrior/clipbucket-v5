<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00100 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('add_member', [
            'fr'=>'Créer un nouvel utilisateur',
            'en'=>'Add member'
        ]);

        self::generateTranslation('new_mem_added', [
            'fr'=>'Le nouvel utilisateur a été correctement ajouté'
        ]);
    }

}
