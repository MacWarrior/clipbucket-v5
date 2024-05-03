<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00022 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'mp4boxpath\';';
        self::query($sql);
    }
}