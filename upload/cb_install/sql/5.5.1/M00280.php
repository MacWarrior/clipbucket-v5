<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00280 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE ' . tbl('video_resolution') . '
                SET video_bitrate = CASE 
                    WHEN title = \'2160p\' THEN 17472000
                    WHEN title = \'1440p\' THEN 7280000
                    WHEN title = \'1080p\' THEN 4096000
                    WHEN title = \'720p\'  THEN 2500000
                    WHEN title = \'480p\'  THEN 700000
                    WHEN title = \'360p\'  THEN 400000
                    WHEN title = \'240p\'  THEN 240000
                    ELSE video_bitrate
                END
                WHERE (video_bitrate = 0);';
        self::query($sql);

        $sql = 'UPDATE ' . tbl('video_resolution') . ' SET enabled = 1 WHERE (SELECT COUNT(*) FROM (SELECT * FROM ' . tbl('video_resolution') . ') AS tmp WHERE enabled = 1) = 0;';
        self::query($sql);
    }
}
