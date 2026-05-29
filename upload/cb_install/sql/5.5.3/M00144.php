<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00144 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('created_new_playlist', [
            'fr' => 'Création d\'une playlist',
            'en' => 'Create new playlist'
        ]);
        self::generateTranslation('upload_thumb', [
            'fr' => 'Téléversement de la vignette',
            'en' => 'Upload thumbnail'
        ]);
        self::generateTranslation('photo_upload', [
            'fr' => 'Téléversement de photo',
            'en' => 'Photo upload'
        ]);
        self::generateTranslation('see_element', [
            'fr' => 'Voir l\'élément',
            'en' => 'See element'
        ]);
        self::generateTranslation('v_comment', [
            'fr' => 'Commentaire de vidéo',
            'en' => 'Video comment'
        ]);
        self::generateTranslation('p_comment', [
            'fr' => 'Commentaire de photo',
            'en' => 'Photo comment'
        ]);
        self::generateTranslation('cl_comment', [
            'fr' => 'Commentaire de collection',
            'en' => 'Collection comment'
        ]);
        self::generateTranslation('import_tmdb', [
            'fr' => 'Import TMDb',
            'en' => 'Import TMDb'
        ]);
        self::generateTranslation('background_upload', [
            'fr' => 'Téléversement de la couverture',
            'en' => 'Background upload'
        ]);
        self::generateTranslation('avatar_upload', [
            'fr'=>'Téléversement de l\'avatar',
            'en'=>'Avatar upload'
        ]);
        $sql = 'UPDATE `{tbl_prefix}action_log` SET `action_type` = \'upload_photo\' WHERE `action_type` LIKE \'photo_added\'';
        self::query($sql);
    }
}
