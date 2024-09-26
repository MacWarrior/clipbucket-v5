<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00140 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('admin_account', [
            'fr'=>'Compte administrateur',
            'en'=>'Admin account'
        ]);

        self::generateTranslation('timezone_not_corresponding', [
            'fr'=>'Le fuseau horaire %s ne correspond pas à celui de la base de donnée',
            'en'=>'Timezone %s does not match database\'s one'
        ]);
    }
}
