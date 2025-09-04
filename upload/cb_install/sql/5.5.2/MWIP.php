<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generatePermission(4, 'download_speed_limit', 'download_speed_limit_desc', [
           1 => 0,
           2 => 0,
           3 => 0,
           4 => 0,
           5 => 0,
           6 => 0
       ]);

       self::generateTranslation('download_speed_limit', [
           'fr'=>'Vitesse limite de téléchargement',
           'en'=>'Download speed limit'
       ]);

       self::generateTranslation('download_speed_limit_desc', [
           'fr'=>'Limite la vitesse de téléchargement à la valeur indiquée (0 pour aucune limite)',
           'en'=>'Limit the download speed to specified value (0 for no limits)'
       ]);

       self::generateTranslation('kbps', [
           'fr'=>'kbit/s',
           'en'=>'kbps'
       ]);
    }
}
