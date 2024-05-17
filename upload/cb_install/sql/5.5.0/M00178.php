<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00178 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='DROP TABLE IF EXISTS `{tbl_prefix}validation_re`;';
        self::query($sql);
    }
}