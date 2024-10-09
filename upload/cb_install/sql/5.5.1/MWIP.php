<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('channel_doesnt_exists', [
           'fr'=>'La chaîne n\'existe pas',
           'en'=>'Channel doesn\'t'
       ]);

    }
}
