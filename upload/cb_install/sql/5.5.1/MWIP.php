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
        self::updateTranslation('video_subtitle_management', [
            'fr'=>'Fichiers sous-titres',
            'en'=>'Subtitle files'
        ]);

        self::updateTranslation('video_file_management', [
            'fr'=>'Fichiers vidéos',
            'en'=>'Video files'
        ]);

        self::updateTranslation('vdo_cat_msg', [
            'en'=>'You may select up to %s categories'
        ]);

        self::generateTranslation('max_video_categories', [
            'fr'=>'Catégories maximum',
            'en'=>'Max categories'
        ]);
        self::generateTranslation('max_video_categories_hint', [
            'fr'=>'Nombre maximum de catégories par vidéo ; 0 pour aucune limite',
            'en'=>'Maximum categories per video ; 0 for unlimited'
        ]);
    }
}
