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
        self::generateTranslation('file_not_found', [
            'fr'=>'Fichier introuvable',
            'en'=>'File not found'
        ]);

        self::generateTranslation('file_has_been_updated', [
            'fr'=>'Le fichier a été mis à jour',
            'en'=>'File has been updated'
        ]);

        self::generateTranslation('unable_to_write_file', [
            'fr'=>'Impossible d\'accéder au fichier en écriture',
            'en'=>'Unable to write file'
        ]);

        self::generateTranslation('no_file_selected', [
            'fr'=>'Aucun fichier valide sélectionné',
            'en'=>'No file selected'
        ]);

        self::generateTranslation('warning_official_cb_template', [
            'fr'=>'Toutes les éditions réalisées sur le thème officiel ClipBucketV5 seront automatiquement rétablies à chaque mise à jour du coeur',
            'en'=>'All editions made on official ClipBucketV5 theme will be automatically reverted on every core update'
        ]);

    }

}
