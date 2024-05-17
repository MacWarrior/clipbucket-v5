<?php
namespace V5_4_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00002 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}modules`;';
        self::query($sql);
    }
}