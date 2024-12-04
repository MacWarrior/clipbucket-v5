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
        self::generateTranslation('recommended_dimension', [
            'fr' => 'Taille minimum recommandée : %s x %s px',
            'en' => 'Minimum recommended size : %s x %s px'
        ]);

        self::generateTranslation('favicon', [
            'fr' => 'Icône du site',
            'en' => 'Favicon'
        ]);

        self::generateTranslation('tips_logo', [
            'fr'=>'Le logo est affiché en haut de chaque page',
            'en'=>'Logo is displayed on top of each page'
        ]);

        self::generateTranslation('tips_favicon', [
            'fr'=>'L\'icône du site est ce que vous voyez dans les onglets du navigateur, les marques-pages et raccourcis',
            'en'=>'Favicon is what you see in browser tabs, bookmarks and shortcuts'
        ]);

        self::generateTranslation('wrong_image_extension', [
            'fr'=>'Seules les extensions suivantes sont prise en charge: %s',
            'en'=>'Only these extensions are allowed for upload: %s'
        ]);
    }
}