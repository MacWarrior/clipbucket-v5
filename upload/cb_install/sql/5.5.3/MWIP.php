<?php

namespace V5_5_3;

use Photo;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('maximum_image_size', [
            'fr' => 'Taille maximale de l\'image',
            'en' => 'Maximum image size'
        ]);

        self::generateTranslation('unsupported_photo_type', [
            'fr' => '%s n\'est pas une extension supportée pour les photos',
            'en' => '%s is not a supported photo extension'
        ]);

        self::generateTranslation('allowed_photo_extensions', [
            'fr' => 'Extensions de photo autorisées',
            'en' => 'Allowed photo extensions'
        ]);

        self::generateTranslation('usr_background_update', [
            'fr'=>'La couverture a été mise à jour',
            'en'=>'Background have been updated'
        ]);

        self::generateTranslation('file_size_exceeds', [
            'fr' => 'La taille du fichier dépasse \'%s mbs\''
        ]);
        self::deleteConfig('max_profile_pic_size');
        self::deleteConfig('max_bg_size');
        
        self::updateTranslation('file_size_exceeds', [
            'en'    => 'File size exceeds \'%s mbs\'',
            'de'    => 'Dateigröße überschreitet \'%s mbs\'',
            'esp'   => 'El tamaño del archivo excede \'%s mbs\'',
            'pt-BR' => 'Tamanho do arquivo excede \'%s mbs\'',
        ]);

        $allowed_types = array_intersect(explode(',', config('allowed_photo_types')), Photo::getAllowedUploadTypes());
        if (empty($allowed_types)) {
            $allowed_types = Photo::getAllowedUploadTypes();
        }
        self::updateConfig('allowed_photo_types', implode(',', $allowed_types));
        self::updateConfig('max_photo_size', config('max_upload_size'));
        self::generateTranslation('file_width_exceeds', [
            'fr' => 'La largeur de l’image ne peux dépasser %spx',
            'en' => 'Image width can’t exceed %spx'
        ]);

        self::updateTranslationKey('usr_avatar_bg_update', 'usr_avatar_update');
        self::updateTranslation('usr_avatar_update', [
            'fr' => 'L\'avatar a été mis à jour',
            'en'=> 'User avatar has been updated'
        ]);

        self::generateTranslation('s_cant_exceed_s', [
            'fr'=>'%s ne peut pas dépasser %s',
            'en'=>'%s can\'t exceed %s'
        ]);

        self::generateTranslation('max_upload_size', [
            'fr'=>'Taille maximale de fichier téléversé',
            'en'=>'Maximum upload file size'
        ]);

        self::generateTranslation('max_upload_size_hint', [
            'fr'=>'Taille maximale globale des fichiers autorisés à être téléversés',
            'en'=>'Global maximum filesize allowed to be uploaded'
        ]);

    }
}
