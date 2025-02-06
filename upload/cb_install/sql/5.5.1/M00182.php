<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00182 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('error_format_date', [
            'fr'=>'Format de date incorrect',
            'en'=>'Incorrect date format'
        ]);
    }
}
