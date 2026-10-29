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
        self::generateTranslation('add_new_page', [
            'fr'=>'Créer une nouvelle page',
            'en'=>'Create a new page'
        ]);
        self::generateTranslation('display_in_footer', [
            'fr'=>'Afficher dans le bas de page',
            'en'=>'Display in footer'
        ]);
        self::generateTranslation('hide_from_footer', [
            'fr'=>'Masquer du bas de page',
            'en'=>'Hide from footer'
        ]);
        self::generateTranslation('page_code', [
            'fr'=>'Code de la page',
            'en'=>'Page Code'
        ]);
        self::generateTranslation('page_title', [
            'fr'=>'Titre de la page',
            'en'=>'Page Title'
        ]);
        self::generateTranslation('page_content', [
            'fr'=>'Contenu de la page',
            'en'=>'Page Content'
        ]);
    }
}
