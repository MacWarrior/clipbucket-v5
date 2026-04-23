<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateConfig('random_photo_order', 'no');

        self::generateTranslation('option_random_photo_order', [
            'fr'=>'Activer l\'ordre aléatoire pour les photos',
            'en'=>'Enable random photos order'
        ]);

        self::query('INSERT IGNORE INTO `{tbl_prefix}sorts` (`label`, `type`) VALUES (\'random\', \'photos\')');
    }
}
