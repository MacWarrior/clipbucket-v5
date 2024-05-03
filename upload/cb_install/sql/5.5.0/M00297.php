<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00297 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}users` SET `banned_users` = \'\' WHERE `userid` = 1 AND `banned_users` = \'test\';';
        self::query($sql);
    }
}