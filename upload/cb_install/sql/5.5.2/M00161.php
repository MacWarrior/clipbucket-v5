<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00161 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        if (config('photo_main_list') == 10) {
            self::updateConfig('photo_main_list', 9);
        }
        if (config('photo_channel_page') == 10) {
            self::updateConfig('photo_channel_page', 9);
        }
    }
}
