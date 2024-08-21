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
        self::generateTranslation('option_list_recent_videos', [
            'fr' => 'Nombre de vidéos récentes',
            'en' => 'Number of recent videos'
        ]);
        self::generateTranslation('option_list_featured_videos', [
            'fr' => 'Nombre de vidéos vedettes',
            'en' => 'Number of featured videos'
        ]);
        self::generateTranslation('tips_only_with_slider_option', [
            'fr' => 'Ne s\'applique qu\'avec le mode d\'affichage caroussel',
            'en' => 'Only apply with slider display mode'
        ]);
        self::generateTranslation('option_enable_fullwidth', [
            'fr' => 'Affichage pleine largeur',
            'en' => 'Fullwidth display'
        ]);

        self::generateConfig('homepage_recent_videos_display', 'paginate');
        self::generateConfig('homepage_featured_video_display', 'paginate');
        self::generateConfig('homepage_recent_video_style', 'classic');
        self::generateConfig('homepage_recent_video_ratio', '1.3333');
        self::generateConfig('list_recent_videos', '20');
        self::generateConfig('list_featured_videos', '20');
        self::generateConfig('home_enable_fullwidth', 'no');

        $sql = 'SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'en\');';
        self::query($sql);
        $sql = 'SET @language_key = \'no_recent_videos_found\' COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET `translation` = \'No recent videos found\' WHERE `id_language_key` = @id_language_key AND `language_id` = @language_id_eng;';
        self::query($sql);
    }
}
