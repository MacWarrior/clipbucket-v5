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
       self::generatePermission(4, 'download_limit', 'download_limit_desc', [
           1 => 0,
           2 => 0,
           3 => 0,
           4 => 0,
           5 => 0,
           6 => 0
       ]);

       self::generateTranslation('download_limit', [
           'fr'=>'Limite de téléchargement',
           'en'=>'Download limit'
       ]);

       self::generateTranslation('download_limit_desc', [
           'fr'=>'Limite la vitesse de téléchargement à la valeur indiquée (0 pour aucune limite)',
           'en'=>'Limit the download speed to specified value (0 for no limits)'
       ]);

       self::generateTranslation('kbps', [
           'fr'=>'kbit/s',
           'en'=>'kbps'
       ]);
    }
}
