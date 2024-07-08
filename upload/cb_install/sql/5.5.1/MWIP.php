<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_user_profil_censor', [
            'fr' => 'Activer la censure du profil utilisateur',
            'en' => 'Enable user profil censor'
        ]);

        self::generateConfig('enable_user_profil_censor', 'no');

        self::deleteTranslation('view_channels');
    }
}