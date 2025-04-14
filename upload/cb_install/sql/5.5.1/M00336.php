<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00336 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('approve_x', [
            'fr'=>'%s à valider',
            'en'=>'Approve %s',
        ]);
        self::generateTranslation('approve', [
            'fr'=>'À valider',
            'en'=>'Approve',
        ]);
        self::generateTranslation('see_all_notifications', [
            'fr'=>'Voir toutes les notifications',
            'en'=>'See all notifications',
        ]);
    }
}
