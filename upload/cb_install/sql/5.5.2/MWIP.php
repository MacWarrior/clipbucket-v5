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
        self::generateTranslation('upload_subtitles', [
            'fr'=>'Téléverser des sous-titres'
            ,'en'=>'Upload subtitles'
        ]);

        self::generateTranslation('file', [
            'fr'=>'Fichier',
            'en'=>'File'
        ]);

        self::generateTranslation('submit', [
            'fr'=>'Envoyer',
            'en'=>'Submit'
        ]);

        self::generateTranslation('invalid_subtitle_file', [
            'fr'=>'Fichier de sous-titres invalide',
            'en'=>'Invalid subtitles file'
        ]);

        self::generateTranslation('invalid_subtitle_extension', [
            'fr'=>'Extension de fichier de sous-titres invalide',
            'en'=>'Invalid subtitles file extension'
        ]);

        self::generateTranslation('subtitle_uploaded_successfully', [
            'fr'=>'Les sous-titres ont correctement été téléversés',
            'en'=>'Subtitles uploaded successfully'
        ]);

        self::generateTranslation('file_size_exceeded', [
            'fr'=>'La taille du fichier dépasse la limite autorisée de %s',
            'en'=>'File size exceeded %s'
        ]);

        self::generateTranslation('option_maximum_allowed_subtitle_size', [
            'fr'=>'Taille maximale des sous-titres',
            'en'=>'Maximum allowed subtitles size'
        ]);
        self::generateTranslation('option_can_upload_subtitles', [
            'fr'=>'Activer le téléversement de sous-titres',
            'en'=>'Enable subtitles upload'
        ]);

        self::generateConfig('maximum_allowed_subtitle_size', 2);
        self::generateConfig('can_upload_subtitles', 'no');
    }
}
