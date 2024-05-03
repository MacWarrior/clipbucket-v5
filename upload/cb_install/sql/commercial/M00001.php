<?php
// Use this SQL script to upgrade from CB commercial to 5.


require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';
class M00001 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='UPDATE `{tbl_prefix}video` SET video_version = \'COMMERCIAL\';';
        self::query($sql);
    }
}