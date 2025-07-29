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
        self::generateConfig('enable_multi_factor_authentification', 'allowed');

        self::generateTranslation('option_enable_multi_factor_authentification', [
            'fr'=>'Authentification multifacteur',
            'en'=>'Multi Factor Authentification'
        ]);

        self::generateTranslation('tips_need_confirm_email', [
            'fr'=>'Vous devez d\'abord confirmer votre adresse email',
            'en'=>'You first need to confirm your email address'
        ]);

        self::generateTranslation('allow', [
            'fr'=>'Autoriser',
            'en'=>'Allow'
        ]);

        self::generateTranslation('allowed_by_email', [
            'fr'=>'Activé, par email',
            'en'=>'Enabled by email'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `email_confirmed` BOOL DEFAULT FALSE');
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `multi_factor_auth` ENUM(\'allowed\',\'disallowed\') NOT NULL DEFAULT \'disallowed\' ');

    }

}
