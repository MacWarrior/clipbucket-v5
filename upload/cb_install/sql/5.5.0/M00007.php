<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00007 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'extract_audio_tracks\';';
        self::query($sql);

        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}video_audio_tracks`;';
        self::query($sql);
    }
}