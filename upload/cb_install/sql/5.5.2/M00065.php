<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00065 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::updateTranslation('make_featured', [
            'en'=>'Make featured'
        ]);
        self::updateTranslation('make_unfeatured', [
            'en'=>'Make unfeatured'
        ]);

        self::generateTranslation('make_public', [
            'fr'=>'Rendre publique',
            'en'=>'Make public'
        ]);
        self::generateTranslation('make_private', [
            'fr'=>'Rendre privée',
            'en'=>'Make private'
        ]);
        self::generateTranslation('created_x', [
            'fr'=>'Créée : %s',
            'en'=>'Created : %s'
        ]);
        self::generateTranslation('collection_made_public', [
            'fr'=>'La collection a été basculée en visibilité publique',
            'en'=>'Collection has been switched to public visibility'
        ]);
        self::generateTranslation('collection_made_private', [
            'fr'=>'La collection a été basculée en visibilité privée',
            'en'=>'Collection has been switched to private visibility'
        ]);
        self::generateTranslation('x_collections_made_public', [
            'fr'=>'%s collections ont été basculées en visibilité publique',
            'en'=>'%s collections have been switched to public visibility'
        ]);
        self::generateTranslation('x_collections_made_private', [
            'fr'=>'%s collections ont été basculées en visibilité privée',
            'en'=>'%s collections have been switched to private visibility'
        ]);
    }

}
