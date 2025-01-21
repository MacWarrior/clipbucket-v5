<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `' . tbl('video') . '` ADD COLUMN `convert_percent` FLOAT NULL DEFAULT 0;', [
            'table'  => 'video'
        ], [
            'table'  => 'video',
            'column' => 'convert_percent'
        ]);

        $sql = 'UPDATE `' . tbl('video') . '` SET `convert_percent` = 100 WHERE `status` = \'Successful\';';
        self::query($sql);

        /* Update revision IN :
         *
         * video.class.php : L.83
         * video_convert.php : L.133
         */
    }
}
