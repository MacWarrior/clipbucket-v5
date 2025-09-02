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
        $email_temp_pass = \EmailTemplate::getOneEmail(['code'=>'password_reset_details']);
        if ( !empty($email_temp_pass)) {
            \EmailTemplate::deleteEmail($email_temp_pass['id_email']);
        }

       $email_reset_reset = \EmailTemplate::getOneEmail(['code'=>'password_reset_request']);
       $email_reset_reset['content'] = 'Dear <b>{{user_username}}</b>,
    <br/><br/>
    You have requested a password reset, please follow the link in order to reset your password : <br/>
    <a href="{{reset_password_link}}">Reset my password</a>
    <hr/>
    <br/><br/>
    If somehow above link isn\'t working, please go to : <a href="{{baseurl}}forgot.php?mode=reset_pass">{{baseurl}}forgot.php?mode=reset_pass</a><br/>
    And use your activation code : <b>{{avcode}}</b>
    <br/><br/>
    <div style="text-align:center;font-weight:bold;">
    If you have not requested a password reset, please ignore this message
    </div>
    <hr/>';
        \EmailTemplate::updateEmail($email_reset_reset);

        self::generateTranslation('user_change_pass', [
            'fr' => 'Changer le mot de passe'
        ]);

        self::generateTranslation('enter_email_and_avcode', [
            'fr' => 'Merci de saisir votre adresse mail et le code d\'activation',
            'en' => 'Please enter your email and verification code'
        ]);

        self::generateTranslation('reset_password', [
            'fr' => 'Réinitialiser le mot de passe',
            'en' => 'Reset Password'
        ]);

        self::generateTranslation('confirm_reset_password', [
            'fr' => 'Voulez-vous vraiment réinitialiser le mot de passe de cet utilisateur ?',
            'en' => 'Do you really want to reset password of this user ?'
        ]);

        self::generateTranslation('cant_reset_database_not_up_to_date', [
            'fr' => 'L\'email n\'a pu être envoyé car votre base de donnée n\'est pas à jour.',
            'en' => 'The email could not be sent because your database is not up to date.'
        ]);

        self::generateTranslation('save_new_password', [
            'fr' => 'Sauvegarder le nouveau mot de passe',
            'en' => 'Save new password'
        ]);

        self::generateTranslation('new_password', [
            'fr' => 'Nouveau mot de passe',
            'en' => 'New password'
        ]);

        self::generateTranslation('confirm_new_password', [
            'fr' => 'Confirmer le nouveau mot de passe',
            'en' => 'Confirm new password'
        ]);

        self::generateTranslation('recap_verify_failed', [
            'fr' => 'Le code de vérification n\'est pas valide',
            'en' => 'Verification code is not valid'
        ]);

        self::generateTranslation('if_email_exist_been_sent', [
            'fr' => 'Si cet adresse e-mail est lié à un compte, un e-mail lui a été envoyé',
            'en' => 'If this email address is related with an account, an email has been sent to it'
        ]);

        self::updateTranslation('email_forgot_password_sended', [
            'en' => 'If this email address is associated with a user account, reset instructions has been sent to it'
        ]);
    }

}
