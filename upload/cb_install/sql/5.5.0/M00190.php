<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00190 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'disable_email\', \'no\');';
        self::query($sql);

        $sql = 'SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'en\');';
        self::query($sql);
        $sql = 'SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'fr\');';
        self::query($sql);
        $sql = 'SET @language_id_deu = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'de\');';
        self::query($sql);
        $sql = 'SET @language_id_por = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'pt-BR\');';
        self::query($sql);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'signup_success_usr_ok\');';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET translation = \'Just One More Step\' WHERE id_language_key = @id_language_key AND language_id = @language_id_eng;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET translation = \'Dernière étape\' WHERE id_language_key = @id_language_key AND language_id = @language_id_fra;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET translation = \'Nur noch ein Schritt\' WHERE id_language_key = @id_language_key AND language_id = @language_id_deu;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET translation = \'Apenas mais um passo\' WHERE id_language_key = @id_language_key AND language_id = @language_id_por;';
        self::query($sql);

        self::generateTranslation('disable_email', [
            'en' => 'Disable Emails',
            'fr' => 'Désactiver les emails'
        ]);

        self::generateTranslation('signup_success_usr_ok_description', [
            'en'    => 'Your are just one step behind from becoming an official member of our website.  Please check your email, we have sent you a confirmation email which contains a confirmation link from our website, Please click it to complete your registration.',
            'fr'    => 'Un email de validation viens de vous être envoyé, il contient un lien permettant l\'activation définitive de votre compte .',
            'de'    => 'Sie sind nur noch einen Schritt davon entfernt, ein offizielles Mitglied unserer Website zu werden.  Bitte überprüfen Sie Ihre E-Mail, wir haben Ihnen eine Bestätigungs-E-Mail geschickt, die einen Bestätigungslink von unserer Website enthält. Bitte klicken Sie darauf, um Ihre Registrierung abzuschließen.',
            'pt-BR' => 'Você é apenas um passo para trás de se tornar um meme oficial do nosso site. Por favor, verifique seu e-mail, enviamos um e-mail de confirmação que contém um link de confirmação do nosso site. Por favor, clique nele para completar o seu registro.'
        ]);

        self::generateTranslation('signup_success_usr_ok_description_no_email', [
            'en' => 'Emails have been disabled, please contact an administrator to manually enable your account.',
            'fr' => 'Les emails ont été désactivés, veuillez contacter un administrateur pour une activation manuelle de votre compte.'
        ]);
    }
}