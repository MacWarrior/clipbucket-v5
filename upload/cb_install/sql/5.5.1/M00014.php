<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00014 extends Migration
{
    /**
     * @throws Exception
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

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'enable_edit_button\',\'yes\');';
        self::query($sql);
    }
}