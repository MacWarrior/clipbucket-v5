<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_video_categories_as_submenu', 'no');
        self::generateConfig('enable_photo_categories_as_submenu', 'no');
        self::generateConfig('enable_collection_categories_as_submenu', 'no');
        self::generateConfig('enable_channel_categories_as_submenu', 'no');
        self::generateConfig('main_menu_order', 'video,photo,channel,collection');
        self::generateConfig('enable_all_categ_for_video', 'yes');
        self::generateConfig('enable_all_categ_for_photo', 'yes');
        self::generateConfig('enable_all_categ_for_collection', 'yes');
        self::generateConfig('enable_all_categ_for_channel', 'yes');
        self::generateTranslation('main_menu', [
            'fr'=>'Menu principal',
            'en'=>'Main menu'
        ]);
        self::generateTranslation('option_enable_video_categories_as_submenu', [
            'fr' => 'Activer les catégories de vidéos comme sous-menu',
            'en' => 'Enable videos categories as submenus'
        ]);
        self::generateTranslation('option_enable_photo_categories_as_submenu', [
            'fr' => 'Activer les catégories de photos comme sous-menu',
            'en' => 'Enable photos categories as submenus'
        ]);
        self::generateTranslation('option_enable_collection_categories_as_submenu', [
            'fr' => 'Activer les catégories de collections comme sous-menu',
            'en' => 'Enable collections categories as submenus'
        ]);
        self::generateTranslation('option_enable_channel_categories_as_submenu', [
            'fr' => 'Activer les catégories de channels comme sous-menu',
            'en' => 'Enable channels categories as submenus'
        ]);
        self::generateTranslation('option_main_menu_order', [
            'fr'=>'Ordre d\'affichage des sections',
            'en'=>'Sections order'
        ]);
        self::generateTranslation('category_name' , [
            'fr'=>'Nom de la catégorie',
            'en'=>'Category name'
        ]);
        self::generateTranslation('enable_categ_as_submenu', [
            'fr'=>'Activer les catégories comme sous-menu pour :',
            'en' => 'Enable categories as submenus for :'
        ]);
        self::generateTranslation('enable_all_categ_for', [
            'fr'=>'Activer toutes les catégories pour :',
            'en' => 'Enable all categories for :'
        ]);
    }
}