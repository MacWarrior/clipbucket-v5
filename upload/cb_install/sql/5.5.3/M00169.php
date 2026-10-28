<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00169 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('video_enable_fullwidth', 'no');
    }
}
