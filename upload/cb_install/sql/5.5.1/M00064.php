<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00064 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::deleteTranslation('basic_info');
    }
}