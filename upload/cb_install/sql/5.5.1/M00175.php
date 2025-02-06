<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00175 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('missing_timezone', [
           'fr'=>'Timezone manquante',
           'en'=>'Missing timezone'
       ]);
    }
}
