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
        self::generateTranslation('option_homepage_enable_popin_video', [
            'fr' => 'Activer les vidéos dans une pop-in',
            'en' => 'Enable popin video'
        ]);
        self::generateTranslation('option_homepage_recent_videos_display', [
            'fr' => 'Mode d\'affichage des vidéos récentes',
            'en' => 'Recent videos display mode'
        ]);
        self::generateTranslation('option_homepage_featured_video_display', [
            'fr' => 'Mode d\'affichage des vidéos mises en avant',
            'en' => 'Featured videos display mode'
        ]);
        self::generateTranslation('option_paginate', [
            'fr' => 'Pagination',
            'en' => 'Paginate'
        ]);
        self::generateTranslation('option_slider', [
            'fr' => 'Caroussel',
            'en' => 'Slider'
        ]);

        self::generateConfig('homepage_recent_videos_display', 'paginate');
        self::generateConfig('homepage_featured_video_display', 'paginate');
    }
}
