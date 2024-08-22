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
        self::generateTranslation('manage_items', [
            'fr' => 'Gestion des objets'
        ]);

        self::generateTranslation('no_collection_found', [
            'fr' => 'Aucune collection trouvée'
        ]);

        self::generateTranslation('cannot_be_own_parent', [
            'fr' => 'Une collection ne peut pas être sa propre collection parente',
            'en' => 'A collection cannot be it\'s own parent'
        ]);

        self::generateTranslation('collection_type_must_be_same_as_parent', [
            'fr' => 'Le type de collection doit être identique à celui du parent',
            'en' => 'Collection\'s type must be the same as the parent one'
        ]);

        self::deleteTranslation('view');

        self::generateTranslation('view', [
            'fr' => 'Visionner',
            'en' => 'View'
        ]);

        self::generateTranslation('templates', [
            'fr' => 'Modèles',
            'en' => 'Templates'
        ]);

        self::generateTranslation('players', [
            'fr' => 'Lecteurs',
            'en' => 'Players'
        ]);

        self::generateTranslation('pages', [
            'fr'=>'Pages',
            'en'=>'Pages'
        ]);

        self::generateTranslation('make_feartured', [
            'fr'=>'Mettre en vedette',
            'en'=>'Make featured'
        ]);
    }
}