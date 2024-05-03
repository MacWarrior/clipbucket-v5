<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00191 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('number', [
            'en' => 'Number',
            'fr' => 'Numéro'
        ]);

        self::generateTranslation('confirm_delete_subtitle_file', [
            'en' => 'Are you sure you want to delete subtitle track n°%s ?',
            'fr' => 'Êtes vous certains de vouloir supprimer la piste de sous titre n°%s ?'
        ]);

        self::generateTranslation('video_subtitle_management', [
            'en' => 'Video subtitle file management',
            'fr' => 'Gestion des fichiers de sous-titre'
        ]);

        self::generateTranslation('video_subtitles_deleted_num', [
            'en' => 'Subtitle track n°%s has been deleted',
            'fr' => 'La piste n°%s des sous-titres a été supprimée'
        ]);
    }
}