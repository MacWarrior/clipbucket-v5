<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00173 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('user_cant_receive_pm', [
           'fr'=>'L\'utilisateur %s ne peut pas recevoir de message privés',
           'en'=>'User %s cannot receive private messages'
       ]);
    }
}
