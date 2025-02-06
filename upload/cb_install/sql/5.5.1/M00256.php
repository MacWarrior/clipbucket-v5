<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00256 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::deleteTranslation('video_deleted');
    }
}