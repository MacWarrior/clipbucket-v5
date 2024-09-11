<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00128 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('collection_not_found', [
            'fr' => 'Une collection est nécessaire pour compléter la configuration de la photo',
            'en' => 'A collection is requiered to complete photo configuration'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('photos') . ' DROP COLUMN collection_id', [
            'table'=>'photos',
            'column'=>'collection_id'
        ]);

        self::generateTranslation('edit_collection', [
            'fr'=>'Editer la collection'
        ]);

        self::generateTranslation('edit_photo', [
            'fr'=>'Editer la photo',
            'en'=>'Edit photo'
        ]);

        self::generateTranslation('photo_title', [
            'fr'=>'Titre de la photo'
        ]);

        self::generateTranslation('photo_caption', [
            'fr'=>'Description de la photo'
        ]);

        self::generateTranslation('photo_success_deleted', [
            'fr'=>'La photo a été supprimée avec succès'
        ]);
    }
}
