<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00330 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE ' . tbl('video_resolution') . '
                SET video_bitrate = 16380000
                WHERE title = \'2160p\' AND video_bitrate = 17472000;';
        self::query($sql);

        $sql = 'UPDATE ' . tbl('video_resolution') . '
                SET width = 3840
                WHERE title = \'2160p\' AND width = 4096;';
        self::query($sql);

        $sql = 'UPDATE ' . tbl('video_resolution') . '
                SET width = 426
                WHERE title = \'240p\' AND width = 428;';
        self::query($sql);
    }
}
