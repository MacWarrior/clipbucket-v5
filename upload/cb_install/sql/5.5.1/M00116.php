<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00116 extends \Migration
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

        self::generateTranslation('templates', [
            'fr' => 'Thèmes',
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

        self::generateTranslation('make_featured', [
            'fr'=>'Mettre en vedette',
            'en'=>'Make featured'
        ]);
        self::generateTranslation('make_unfeatured', [
            'fr'=>'Retirer des vedettes',
            'en'=>'Make unfeatured'
        ]);
        self::generateTranslation('collection_featured', [
            'fr'=>'La collection a été ajoutée aux vedettes'
        ]);
        self::generateTranslation('collection_unfeatured', [
            'fr'=>'La collection a été retirée des vedettes'
        ]);

        self::generateTranslation('selected_collects_del', [
            'fr'=>'Les collections sélectionnées ont été supprimées'
        ]);

        self::generateTranslation('object', [
            'fr' => 'objet',
            'en' => 'object'
        ]);

        self::generateTranslation('objects', [
            'fr' => 'objets',
            'en' => 'objects'
        ]);

        self::generateTranslation('view_channel_comments', [
            'fr'=>'Voir les commentaires de chaine',
            'en'=>'View channel comments'
        ]);

        self::query('INSERT INTO ' . tbl('categories').' (id_category_type, category_name, is_default) VALUES((select id_category_type from '.tbl('categories_type').' where name = \'photo\'), \'Uncategorized\', \'yes\')');

        self::generateTranslation('collect_added_msg', [
            'fr'=>'La collection a été ajoutée'
        ]);
    }
}