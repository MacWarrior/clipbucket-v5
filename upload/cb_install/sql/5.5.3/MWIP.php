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
        self::generateTranslation('video_not_exist_or_cant_access', [
            'fr'=>'Cette video n’existe pas ou ne vous est pas accessible',
            'en'=>'This video does not exist or you cannot access to it'
        ]);
    }
}
