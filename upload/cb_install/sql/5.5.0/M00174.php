<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00174 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('nb_files', [
            'en' => 'Number of files',
            'fr' => 'Nombre de fichiers'
        ]);

        self::generateTranslation('video_file_management', [
            'en' => 'Video file management',
            'fr' => 'Gestion des fichiers vidéos'
        ]);

        self::generateTranslation('confirm_delete_video_file', [
            'en' => 'Are you sure you want to delete %sp resolution ?',
            'fr' => 'Êtes vous certains de vouloir supprimer la résolution %sp ?'
        ]);
    }
}