<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00006 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
            (\'player_subtitles\', \'1\'),
            (\'subtitle_format\', \'webvtt\');
        ';
        self::query($sql);
    }
}