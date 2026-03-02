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
            'fr'=>'%s n\'est pas supporté pour le chargement de photo',
            'en'=>'%s is not supported for uploading'
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

        $allowed_types = array_intersect(explode( ',', config('allowed_photo_types')), Photo::getAllowedUploadTypes());
        if (empty($allowed_types)) {
            $allowed_types = Photo::getAllowedUploadTypes();
        }
        self::updateConfig('allowed_photo_types', implode(',', $allowed_types));


    }
}
