<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00132 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('viewed_recently', [
            'fr'=>'Vue récemment',
            'en'=>'Viewed recently'
        ]);
        self::generateTranslation('shorter_video', [
            'fr'=>'Plus courte',
            'en'=>'Shorter'
        ]);
        self::generateTranslation('longer_video', [
            'fr'=>'Plus longue',
            'en'=>'Longer'
        ]);
    }
}
