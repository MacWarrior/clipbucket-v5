<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00001 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        $sql = 'INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'enable_update_checker\', \'1\');';
        self::query($sql);
    }
}