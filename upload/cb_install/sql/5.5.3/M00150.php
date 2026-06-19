<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00150 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('noted_x', [
           'fr'=>'Noté %s',
           'en'=>'Noted %s'
       ]);
       self::generateTranslation('over_x_ratings', [
           'fr'=>'sur %s votes',
           'en'=>'over %s ratings'
       ]);
    }
}
