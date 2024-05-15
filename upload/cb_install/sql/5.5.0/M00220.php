<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00220 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('lang_restored', [
            'en' => 'Language %s has been restores succesfully.',
            'fr' => 'La langue %s a été restaurée avec succès'
        ]);

        self::generateTranslation('language_name', [
            'en' => 'Language Name',
            'fr' => 'Libellé de la langue'
        ]);

        self::generateTranslation('restore_language', [
            'en' => 'Restore language',
            'fr' => 'Restaurer une langue'
        ]);

        self::generateTranslation('restore', [
            'en' => 'Restore',
            'fr' => 'Restaurer'
        ]);
    }
}