<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00068 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}config` SET `value` = \'yes\' WHERE `name` = \'photo_rating\' AND `value` = \'1\'';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}config` SET `value` = \'yes\' WHERE `name` = \'own_photo_rating\' AND `value` = \'1\'';
        self::query($sql);
    }
}