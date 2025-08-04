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
            'fr'=>'Un email de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.',
            'en'=>'A confirmation email has been sent to your address. Please check your inbox.'
        ]);
        self::generateTranslation('mfa_code_expired', [
            'fr'=>'Le code d\'authentification a expiré, merci d\'en demander un nouveau',
            'en'=>'The authentification code has expired, please request a new one'
        ]);
        self::generateTranslation('user_email_verify_msg', [
            'fr'=>'Pour confirmer votre changement d\'email, veuillez suivre le lien dans le mail que nous venons de vous envoyer',
            'en'=>'To confirm your email change, please follow the link in the email we just sent you'

        ]);
        self::generateTranslation('please_enter_mfa_code', [
            'fr'=>'Merci d\'entrer votre code d\'authentification',
            'en'=>'Please enter your authentification code'
        ]);
        self::generateTranslation('disable', [
            'fr'=>'Désactiver',
            'en'=>'Disable'
        ]);

        self::generateTranslation('cant_delete_only_admin', [
            'fr'=>'Vous êtes le seul compte administrateur, veuillez créer un autre compte administrateur pour pouvoir supprimer le votre',
            'en'=>'You are the only administrator, please create another administrator account to be able to delete your own'
        ]);

        self::generateTranslation('email_variable_mfa_code', [
            'fr'=>'Code d\'authentification',
            'en'=>'Authentification code'
        ]);

        self::generateTranslation('multi_factor_auth_err', [
            'fr'=>'La type d\'authentification multifacteur est inconnu',
            'en'=>'Unknown multi factor authentication type'
        ]);

        self::generateTranslation('cant_activate_multi_factor_auth_with_no_confirmed_email', [
            'fr'=>'Vous ne pouvez pas activer l\'authentication multifacteur tant que votre adresse mail n\'est pas validée',
            'en'=>'You can\'t activate multi factor authentication until your email address is confirmed'
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
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD `multi_factor_auth` ENUM(\'allowed_email\',\'disabled\') NOT NULL DEFAULT \'disabled\' ', [
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
In order to verify your email address, please validate your account by <a href="{{baseurl}}email_confirm.php?mode=email_confirm&av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
<br/><br/>
If somehow above link isn\\\'t working, please go to : <a href="{{baseurl}}email_confirm.php?mode=email_confirm">{{baseurl}}email_confirm.php?mode=email_confirm</a><br/>
And use your activation code : <b>{{avcode}}</b>
<br/><br/>
Have a nice day !\', 0)';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}email_variable_link` (`id_email`, `id_email_variable`)
            VALUES ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = \'verify_email\' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = \'avcode\' LIMIT 1)); ';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}email` (code, id_email_template, is_deletable, title, content, disabled) VALUES (\'mfa_code\',1,0,\'[{{website_title}}] Authentification\',\'Hello <b>{{user_username}}</b>,
<br/><br/>
Here is your authentification code : <b>{{mfa_code}}</b>

<br/><br/>
Have a nice day !\', 0)';
        self::query($sql);

        $sql='INSERT IGNORE INTO `{tbl_prefix}email_variable` (code, type, language_key) VALUES
            (\'mfa_code\',\'email\', \'email_variable_mfa_code\')';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}email_variable_link` (`id_email`, `id_email_variable`)
            VALUES ((SELECT id_email FROM `{tbl_prefix}email` WHERE code = \'mfa_code\' LIMIT 1), (SELECT id_email_variable FROM `{tbl_prefix}email_variable` WHERE code = \'mfa_code\' LIMIT 1)); ';
        self::query($sql);

        self::generateTranslation('usr_actiavation_msg1', [
            'fr'=>'Demander un code d\'activation'
        ]);

        self::generateTranslation('email_confirmation', [
            'fr'=>'Confirmation d\'adresse email',
            'en'=>'Email address confirmation'
        ]);

        self::generateTranslation('email_confirmation_tips', [
            'fr'=>'Veuillez renseigner votre code d\'activation envoyé par email pour confirmer votre adresse email.',
            'en'=>'Please enter your activation code sended by email to confirm your email address.'
        ]);

        self::updateTranslation('acitvation_html_message', [
            'en' => 'Please enter your username and activation code sended by email in order to activate your account.'
        ]);
        self::generateTranslation('acitvation_html_message', [
            'fr' => 'Veuillez renseigner votre code d\'activation envoyé par email pour activer votre compte.'
        ]);

        self::generateTranslation('activate_my_account', [
            'en' => 'Activate my account',
            'fr' => 'Activer mon compte'
        ]);

        self::generateTranslation('request_activation_code', [
            'en' => 'Request activation code',
            'fr' => 'Demander un code d\'activation'
        ]);

        self::generateTranslation('email_confirmed', [
            'en' => 'Your email address has been confirmed',
            'fr' => 'Votre adresse email a été confirmée'
        ]);

        self::generateTranslation('email_already_confirmed', [
            'en' => 'Your email address has already been confirmed',
            'fr' => 'Votre adresse email a déjà été confirmée'
        ]);

        self::generateTranslation('acitvation_html_message2', [
            'fr' => 'Veuillez renseigner votre adresse email pour demander un code d\'activation.'
        ]);

        self::generateTranslation('avcode_incorrect', [
            'fr' => 'Le code d\'activation est incorrect'
        ]);

        self::generateTranslation('email_forgot_password_sended', [
            'en' => 'If this email addresse is associated with a user acount, reset instructions has been sent to it',
            'fr' => 'Si cette adresse email est bien associée à un compte utilisateur, les instructions de réinitialisation y ont été envoyées'
        ]);

        self::generateTranslation('forgot_password_tips', [
            'en' => 'Please enter email address attached to your account ; password reset instructions will be sent to you',
            'fr' => 'Veuillez renseigner l\'adresse email rattachée à votre compte ; les instructions de réinitialisation vous seront envoyées'
        ]);
    }

}
