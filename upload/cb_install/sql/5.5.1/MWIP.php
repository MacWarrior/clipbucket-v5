<?php

namespace V5_5_1;

require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('translation_already_exist_choose_other_name', [
            'fr' => 'Le code de traduction "%s" existe déjà. Merci de choisir un autre nom de page.',
            'en' => 'Translation code "%s" already exists. Please choose a different name.'
        ]);

        self::generateTranslation('page_name_cant_have_space', [
            'fr' => 'Le nom de la page ne peut pas contenir d\'espace',
            'en' => 'There are can\'t be spaces in page\'s name.'
        ]);

        $pages = \cbpage::getInstance()->get_pages();
        foreach ($pages as $page) {
            if ($page['page_name'] == '403 Error' || $page['page_name'] == '404 Error') {
                self::query('DELETE FROM '.tbl('pages').' WHERE page_id = ' . $page['page_id']);
            } else {
                self::updateTranslationKey($page['page_name'], 'page_name_' . str_replace('page_name_', '', str_replace(' ', '_', strtolower($page['page_name']))));
                self::query('UPDATE ' . tbl('pages') . ' SET page_name = \'' . str_replace(' ', '_', strtolower($page['page_name'])) .'\' where page_name = \'' . $page['page_name'] .'\'' );
            }
        }

        self::generateTranslation('page_name_about_us', [
            'fr'=>'À propos de nous'
        ]);

        self::generateTranslation('page_name_privacy_policy', [
            'fr'=>'Politique de confidentialité'
        ]);

        self::generateTranslation('page_name_terms_of_service', [
            'fr'=>'Conditions d\'utilisation'
        ]);

        self::generateTranslation('page_name_help', [
            'fr'=>'Aide'
        ]);

        self::generateTranslation('page_name_403_error', [
            'fr'=>'Erreur 403',
            'en'=>'403 Error'
        ]);
        self::generateTranslation('page_name_404_error', [
            'fr'=>'Erreur 404',
            'en'=>'404 Error'
        ]);

        self::generateTranslation('page_display_changed', [
            'fr'=>'L\'affichage de la page a été modifié',
            'en'=>'Page display mode has been changed'
        ]);
    }
}
