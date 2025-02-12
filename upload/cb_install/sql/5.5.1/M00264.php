<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00264 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('thumb_background_color', '#000000');

        self::generateTranslation('option_thumb_background_color', [
            'fr'=>'Couleur de fond des vignettes',
            'en'=>'Thumb background color',
        ]);
    }
}
