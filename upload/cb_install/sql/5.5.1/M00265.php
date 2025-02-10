<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00265 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::updateTranslation('thumb_regen_start', [
            'fr'=>'Regénération des vignettes en cours...',
            'en'=>'Ongoing thumbs regeneration...'
        ]);
    }
}
