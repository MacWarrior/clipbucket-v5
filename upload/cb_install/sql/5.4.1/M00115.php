<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00115 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        $sql = 'INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'player_default_resolution\', \'360\');';
        self::query($sql);
    }
}