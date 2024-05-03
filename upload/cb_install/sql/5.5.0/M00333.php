<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00333 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('category_type_unknown', [
            'en' => 'Unknown category type : %s',
            'fr' => 'Type de catégorie inconnue : %s'
        ]);
    }
}