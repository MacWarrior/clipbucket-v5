<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00186 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE '.tbl('video_conversion_queue').' ADD COLUMN audio_track VARCHAR(255) NULL',[
            'table' => 'video_conversion_queue',
        ], [
            'table' => 'video_conversion_queue',
            'column' => 'audio_track'
        ]);

    }

}
