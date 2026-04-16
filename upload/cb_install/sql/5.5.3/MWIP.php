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
        self::generateTranslation('allowed_video_extensions', [
            'fr'=>'Extensions de vidéo autorisées',
            'en'=>'Allowed video extensions'
        ]);

        self::generateTranslation('tag_too_short_dynamic', [
            'fr'=>'Les tags de moins de %s caractères ne sont pas autorisés',
            'en'=>'Tags less than %s characters are not allowed'
        ]);

    }
}
