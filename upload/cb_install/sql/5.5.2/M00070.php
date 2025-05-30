<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00070 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_photo_ratio', [
            'fr'=>'Ratio de la photo',
            'en'=>'Photo ratio'
        ]);

        self::generateTranslation('option_photo_ratio_help', [
            'fr'=>'Votre vignette de photo, et les vignettes de taille moyenne seront reformater en fonction de ces ratios',
            'en'=>'Your photo thumb and medium size thumb will be resized according to these ratios'
        ]);

        self::generateTranslation('option_large_photo_width', [
            'fr'=>'Largeur des grandes photos',
            'en'=>'Large photo width'
        ]);

        self::generateTranslation('option_crop_image', [
            'fr'=>'Recadrer les images',
            'en'=>'Crop images'
        ]);

        self::generateTranslation('option_photo_thumb_size', [
            'fr'=>'Taille des vignettes',
            'en'=>'Thumb size'
        ]);

        self::generateTranslation('width', [
            'fr'=>'Largueur',
            'en'=>'Width'
        ]);

        self::generateTranslation('height' , [
            'fr'=>'Longueur',
            'en'=>'Height'
        ]);

        self::generateTranslation('option_medium_photo_size', [
            'fr'=>'Taille des photos moyennes',
            'en'=>'Medium thumb size'
        ]);
    }
}
