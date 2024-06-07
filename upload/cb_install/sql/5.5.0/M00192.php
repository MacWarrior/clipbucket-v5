<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00192 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('plugin_compatible', [
            'en'=>'Plugin is compatible with current Clipbucket version',
            'fr'=>'Le plugin est compatible avec la version actuelle de Clipbucket'
        ]);

        self::generateTranslation('plugin_not_compatible', [
            'en'=>'Plugin might not be compatible with current Clipbucket version',
            'fr'=>'Le plugin peut ne pas être compatible avec la version actuelle de Clipbucket'
        ]);
    }
}