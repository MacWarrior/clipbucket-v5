<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00341 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('dob_required', [
            'en' => 'Date of birth is required',
            'fr' => 'La date de naissance doit être renseignée'
        ]);
    }
}