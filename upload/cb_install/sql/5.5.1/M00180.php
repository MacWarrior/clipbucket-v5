<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00180 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::updateTranslation('channel_doesnt_exists', [
           'en'=>'Channel doesn\'t exists'
       ]);
    }
}
