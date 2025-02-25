<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00274 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateConfig('logo_update_timestamp', time());
    }
}
