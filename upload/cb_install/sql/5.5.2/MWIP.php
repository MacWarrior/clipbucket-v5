<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('active_template', [
            'fr'=>'Template actif',
            'en'=>'Active template'
        ]);

        self::generateTranslation('available_templates', [
            'fr'=>'Templates disponibles',
            'en'=>'Available templates'
        ]);

        self::generateTranslation('create_copy', [
            'fr'=> 'Créer une copie',
            'en'=> 'Create a copy'
        ]);

        self::generateTranslation('delete_copy', [
            'fr'=> 'Supprimer la copie',
            'en'=> 'Delete a copy'
        ]);

        self::generateTranslation('edit_copy', [
            'fr'=> 'Editer la copie',
            'en'=> 'Edit a copy'
        ]);

        self::generateTranslation('delete_template_confirmation', [
            'fr'=>'Voulez-vous vraiment supprimer ce template ?',
            'en'=>'Are you sure you want to delete this template ?'
        ]);

    }

}
