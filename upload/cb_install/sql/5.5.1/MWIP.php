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
       self::generateTranslation('enable_channel_page_desc', [
           'fr'=>'L\'utilisateur peur avoir une page de chaîne',
           'en'=>'User can have a channel page'
       ]);

    }
}
