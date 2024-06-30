<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00014 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('edit_from_BO', [
            'en' => 'From admin area',
            'fr' => 'Depuis l\'administration'
        ]);
        self::generateTranslation('edit_from_FO', [
            'en' => 'From my account',
            'fr' => 'Depuis mon compte'
        ]);
        self::generateTranslation('enable_edit_button', [
            'en' => 'Enable edit button',
            'fr' => 'Activer le bouton d\'édition'
        ]);

        self::generateConfig('enable_edit_button', 'yes');
    }
}