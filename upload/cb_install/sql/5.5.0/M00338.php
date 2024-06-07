<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00338 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_user_dob_edition', [
            'fr' => 'Autoriser l\'édition de la date de naissance'
        ]);
        self::generateTranslation('user_dob_edition_disabled', [
            'fr' => 'L\'édition de la date de naissance est désactivée'
        ]);
    }
}