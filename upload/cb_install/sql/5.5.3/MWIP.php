<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('photo_thumbs_format', 'keep');

        self::generateTranslation('option_photo_thumbs_format', [
            'fr'=>'Format des vignettes photo',
            'en'=>'Photo thumbs format'
        ]);

        self::generateTranslation('photo_thumbs_format_tips', [
            'fr'=>'Conserve le format original de la photo, ou forcer le format WebP',
            'en'=>'Keep original photo format, or force WebP format'
        ]);

        self::generateTranslation('keep_photo_type', [
            'fr'=>'Conserver le format original de la photo',
            'en'=>'Keep original photo format'
        ]);

        self::generateTranslation('webp', [
            'fr'=>'WebP',
            'en'=>'WebP'
        ]);
    }
}
