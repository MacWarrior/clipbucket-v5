<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00259 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('missing_category_report', [
            'fr' => 'Veuillez choisir un motif de signalement',
            'en' => 'Please select a report category'
        ]);
    }
}
