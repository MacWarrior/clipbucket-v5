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
        self::generateTranslation('option_homepage_recent_video_style', [
            'fr' => 'Style des vidéos récentes',
            'en' => 'Recent videos style'
        ]);
        self::generateTranslation('option_modern', [
            'fr' => 'Moderne',
            'en' => 'Modern'
        ]);
        self::generateTranslation('option_classic', [
            'fr' => 'Classique',
            'en' => 'Classic'
        ]);
        self::generateTranslation('option_video_ratio', [
            'fr' => 'Ratio d\'affichage des vidéos',
            'en' => 'Video display ratio'
        ]);

        self::generateConfig('homepage_recent_videos_display', 'paginate');
        self::generateConfig('homepage_featured_video_display', 'paginate');
        self::generateConfig('homepage_recent_video_style', 'classic');
        self::generateConfig('homepage_recent_video_ratio', '1.3333');
    }
}
