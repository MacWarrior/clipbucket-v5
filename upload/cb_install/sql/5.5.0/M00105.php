<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00105 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'anonymous_id\';';
        self::query($sql);
    }
}