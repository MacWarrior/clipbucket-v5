<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00205 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_country', [
            'en' => 'Enable country selection',
            'fr' => 'Activer la sélection du pays'
        ]);

        self::generateTranslation('option_enable_gender', [
            'en' => 'Enable gender selection',
            'fr' => 'Activer la sélection du genre'
        ]);

        self::generateTranslation('option_enable_user_category', [
            'en' => 'Enable user category selection',
            'fr' => 'Activer la sélection de la catégorie'
        ]);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
        (\'enable_country\', \'yes\'),
        (\'enable_gender\', \'yes\'),
        (\'enable_user_category\', \'yes\');';
        self::query($sql);
    }
}