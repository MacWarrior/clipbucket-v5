<?php

namespace V5_5_1;

use Language;

require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('translation_already_exist_choose_other_name', [
            'fr' => 'Le code de traduction %s existe déjà. Merci de choisir un autre nom de page.',
            'en' => 'Translation code %s already exists. Please choose a different name.'
        ]);

        self::generateTranslation('page_name_cant_have_space', [
            'fr'=>'Le nom de la page ne peut pas contenir d\'espace',
            'en'=>'There are can\'t be spaces in page\'s name.'
        ]);
        global $cbpage;
        $pages = $cbpage->get_pages();

        foreach ($pages as $page) {
            self::generateTranslation('page_name_' . str_replace(' ', '_', strtolower($page['page_name'])), [
                Language::getInstance()->lang => $page['page_title']
            ]);
        }


    }
}
