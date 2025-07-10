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
        self::generateTranslation('max_option_display', [
            'fr'=>'Entrer un nombre entre 1 et le maximum',
            'en'=>'Please type number from 1 to maximum'
        ]);

        self::generateTranslation('display_option', [
            'fr'=>'Option d\'affichage',
            'en'=>'Display option'
        ]);
    }

}
