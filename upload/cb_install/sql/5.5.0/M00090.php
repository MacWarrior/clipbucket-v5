<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00090 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'photo_download\';';
        self::query($sql);
    }
}