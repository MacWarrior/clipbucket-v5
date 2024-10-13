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
        self::generateConfig('enable_visual_editor_comments', 'no');

        self::generateTranslation('option_enable_visual_editor', [
            'fr' => 'Activer l\'éditeur visuel',
            'en' => 'Enable visual editor'
        ]);
    }
}