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
        self::generateConfig('proxy_enable', 'no');
        self::generateConfig('proxy_auth', 'no');
        self::generateConfig('proxy_url', '');
        self::generateConfig('proxy_port', '');
        self::generateConfig('proxy_username', '');
        self::generateConfig('proxy_password', '');
    }
}