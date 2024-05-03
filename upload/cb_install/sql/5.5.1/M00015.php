<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00015 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}config` SET value = CASE WHEN value = \'1\' THEN \'yes\' ELSE \'no\' END WHERE name LIKE \'enable_sub_collection\';';
        self::query($sql);
    }
}