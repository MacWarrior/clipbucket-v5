<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_allow_alias_email', 'yes');

        self::generateTranslation('option_enable_allow_alias_email', [
            'fr'=>'Autoriser les alias d\'emails',
            'en'=>'Allow alias emails'
        ]);

        self::generateTranslation('option_enable_allow_alias_email_hint', [
            'fr'=>'Autoriser le caractère \'+\' dans l\'adresse email',
            'en'=>'Allow + char in email address'
        ]);

        self::generateTranslation('error_alias_email_not_allowed', [
            'fr'=>'Les alias d’emails ne sont pas autorisés',
            'en'=>'Emails alias aren\'t allowed'
        ]);

    }
}
