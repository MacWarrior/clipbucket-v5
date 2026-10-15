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
        self::generateTranslation('display_in_footer', [
            'fr'=>'Afficher dans le bas de page',
            'en'=>'Display in footer'
        ]);

        self::generateTranslation('hide_from_footer', [
            'fr'=>'Masquer du bas de page',
            'en'=>'Hide from footer'
        ]);

        self::generateTranslation('selected_page_hidden', [
            'fr'=>'Les pages sélectionnées ont été masquées',
            'en'=>'Selected pages have been hidden'
        ]);

        self::generateTranslation('selected_page_displayed', [
            'fr'=>'Les pages sélectionnées ont été affichées',
            'en'=>'Selected pages have been displayed'
        ]);
    }
}
