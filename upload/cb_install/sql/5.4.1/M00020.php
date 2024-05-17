<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00020 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
        (\'proxy_enable\', \'no\'),
        (\'proxy_auth\', \'no\'),
        (\'proxy_url\', \'\'),
        (\'proxy_port\', \'\'),
        (\'proxy_username\', \'\'),
        (\'proxy_password\', \'\');';
        self::query($sql);
    }
}