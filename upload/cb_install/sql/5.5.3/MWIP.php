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
        self::generateTranslation('active_template', [
            'fr' => 'Template actif',
            'en' => 'Active template'
        ]);

        self::generateTranslation('available_templates', [
            'fr' => 'Templates disponibles',
            'en' => 'Available templates'
        ]);

        self::generateTranslation('create_copy', [
            'fr' => 'Créer une copie',
            'en' => 'Create a copy'
        ]);

        self::generateTranslation('delete_copy', [
            'fr' => 'Supprimer la copie',
            'en' => 'Delete a copy'
        ]);

        self::generateTranslation('edit_copy', [
            'fr' => 'Editer la copie',
            'en' => 'Edit a copy'
        ]);

        self::generateTranslation('delete_template_confirmation', [
            'fr' => 'Voulez-vous vraiment supprimer ce template ?',
            'en' => 'Are you sure you want to delete this template ?'
        ]);

        self::generateTranslation('selected_template_cannot_be_deleted', [
            'fr' => 'Impossible de supprimer le template actif. Veuillez en sélectionner un autre avant de supprimer ce dernier.',
            'en' => 'Cannot delete active template. Please select another one before deleting this one.'
        ]);

        self::generateTranslation('save', [
            'fr' => 'Enregistrer',
            'en' => 'Save'
        ]);

        self::generateTranslation('error_occurred', [
            'fr' => 'Une erreur est survenue. Merci de recharger la page et essayer à nouveau.',
            'en' => 'An error occurred. Please reload the page and try again.'
        ]);

        self::generateTranslation('saved_success', [
            'fr' => 'Enregistrement terminé avec succès',
            'en' => 'Saved successfully'
        ]);

        self::generateTranslation('html_files', [
            'fr' => 'Fichiers HTML',
            'en' => 'HTML files'
        ]);

        self::generateTranslation('css_files', [
            'fr' => 'Fichiers CSS',
            'en' => 'CSS files'
        ]);

        self::generateTranslation('select_theme_to_edit', [
            'fr' => 'Choisissez un thème à modifier',
            'en' => 'Select a theme to edit'
        ]);

        self::generateTranslation('edit_template', [
            'fr'=>'Édition de template',
            'en'=>'Edit template'
        ]);

        self::generateTranslation('editing_template', [
            'fr' => 'Édition de %s',
            'en' => 'Editing %s'
        ]);
    }

}
