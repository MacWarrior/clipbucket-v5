<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00258 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('missing_email_recipient', [
            'fr' => 'Adresse email du destinataire manquante',
            'en' => 'Missing recipient\'s email'
        ]);
    }
}
