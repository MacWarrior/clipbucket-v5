<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00214 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('lang_name_too_long', [
            'fr'=>'Le nom de la langue ne peut pas dépasser les 20 caractères.',
            'en'=>'The language name cannot exceed 20 characters.'
        ]);
    }
}
