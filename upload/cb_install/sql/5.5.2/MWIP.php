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

        self::generateTranslation('confirm_email', [
            'fr'=>'Confirmer mon email',
            'en'=>'Confirm my email'
        ]);

        self::generateTranslation('email_confirm_last_sent_under_15_min', [
            'fr'=>'Un email vous a déjà été envoyé, merci d\'attendre 15 minutes avant d\'en demander un nouveau',
            'en'=>'An email has already been sent, please wait 15 minutes before requesting a new one'
        ]);

        self::generateTranslation('email_confirm_sent', [
            'fr'=>'L\'email pour confirmer votre adresse mail a bien été envoyé',
            'en'=>'The email for confirming your email address has been sent'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `email_confirmed` BOOL DEFAULT FALSE', [
            'table' => 'users'
        ], [
            'table' => 'users',
            'column' => 'email_confirmed'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `email_temp` VARCHAR( 255 ) ', [
            'table' => 'users'
        ], [
            'table' => 'users',
            'column' => 'email_temp'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `multi_factor_auth` ENUM(\'allowed_email\',\'disallowed\') NOT NULL DEFAULT \'disallowed\' ', [
            'table' => 'users'
        ], [
            'table' => 'users',
            'column' => 'multi_factor_auth'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `mfa_code` VARCHAR( 255 ) NULL ', [
            'table' => 'users'
        ], [
            'table' => 'users',
            'column' => 'mfa_code'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `mfa_date` DATETIME NULL ', [
            'table' => 'users'
        ], [
            'table' => 'users',
            'column' => 'mfa_date'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}email` (code, id_email_template, is_deletable, title, content, disabled) VALUES (\'verify_email\',1,0,\'[{{website_title}}] Email address verification\',\'Hello <b>{{user_username}}</b>,
<br/><br/>
In order to verify your email address, please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
<br/><br/>
If somehow above link isn\\\'t working, please go TO : <a href="{{baseurl}}activation.php">{{baseurl}}activation.php</a><br/>
And use your activation code : <b>{{avcode}}</b>
<br/><br/>
Have a nice day !\', 0)';
        self::query($sql);

    }

}
