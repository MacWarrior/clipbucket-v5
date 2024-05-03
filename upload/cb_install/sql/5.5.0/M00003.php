<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00003 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='DELETE FROM `{tbl_prefix}config` WHERE name IN(\'keep_original\');';
        self::query($sql);

        $sql='INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
            (\'keep_audio_tracks\', \'1\'),
            (\'keep_subtitles\', \'1\');';
        self::query($sql);
    }
}