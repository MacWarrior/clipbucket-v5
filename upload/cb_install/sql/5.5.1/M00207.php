<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00207 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('display_featured_video', 'yes');
        self::generateConfig('featured_video_style', 'classic');
        self::generateConfig('number_featured_video', 20);
        self::generateTranslation('display_featured_video', [
            'fr' => 'Afficher les vidéos vedettes',
            'en' => 'Display featured video'
        ]);

        self::generateTranslation('featured_video_style', [
            'fr'=>'Style des vidéos vedettes',
            'en'=>'Featured video style'
        ]);

        self::generateTranslation('classic', [
            'fr'=>'Classique',
            'en'=>'Classic'
        ]);

        self::generateTranslation('modern', [
            'fr'=>'Moderne',
            'en'=>'Modern'
        ]);
    }
}
