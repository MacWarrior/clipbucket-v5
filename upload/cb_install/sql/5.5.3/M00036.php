<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00036 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateConfig('random_video_order', 'no');

       self::generateTranslation('option_random_video_order', [
           'fr'=>'Activer l\'ordre aléatoire pour les vidéos',
           'en'=>'Enable random videos order'
       ]);

       self::generateTranslation('sort_by_random', [
           'fr'=>'Aléatoire',
           'en'=>'Random'
       ]);

       self::query('INSERT IGNORE INTO `{tbl_prefix}sorts` (`label`, `type`) VALUES (\'random\', \'videos\')');
    }
}
