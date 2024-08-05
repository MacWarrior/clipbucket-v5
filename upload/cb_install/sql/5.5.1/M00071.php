<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00071 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('thumb_regen_start', [
            'fr'=>'Renénération des vignettes en cours...',
            'en'=>'Ongoing thumbs regeneration...'
        ]);

        self::generateTranslation('thumb_regen_end', [
            'fr'=>'Regénération des vignette terminée',
            'en'=> 'Thumbs regeneration ended'
        ]);
    }
}