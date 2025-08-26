<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='DROP TABLE IF EXISTS `{tbl_prefix}conversion_queue`;';
        self::query($sql);

         $sql='CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_conversion_queue` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `videoid` bigint(20) NOT NULL,
                `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `date_started` datetime DEFAULT NULL,
                `date_ended` datetime DEFAULT NULL,
                `is_completed` boolean DEFAULT 0
            )';
         self::query($sql);

        self::insertTool('launch_video_conversion', 'AdminTool::launchVideoConversion', '* * * * *', true);

    }

}
