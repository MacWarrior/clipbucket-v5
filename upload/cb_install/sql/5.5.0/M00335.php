<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00335 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('admin_setting', [
            'en' => 'Admin Settings',
            'fr' => 'Administrateur'
        ]);

        self::generateTranslation('site_setting', [
            'en' => 'Site Settings',
            'fr' => 'Paramétrage du site web'
        ]);

        self::generateTranslation('admin_username', [
            'en' => 'Admin username',
            'fr' => 'Identifiant administrateur'
        ]);

        self::generateTranslation('admin_password', [
            'en' => 'Admin password',
            'fr' => 'Mot de passe administrateur'
        ]);

        self::generateTranslation('admin_email', [
            'en' => 'Admin email',
            'fr' => 'Email administrateur'
        ]);

        self::generateTranslation('save_continue', [
            'en' => 'Save and continue',
            'fr' => 'Enregistrer et continuer'
        ]);

        self::generateTranslation('hint_admin_username', [
            'en' => 'Username can have only alphanumeric characters, Underscores',
            'fr' => 'L\'identifiant ne peut contenir que des caractères alphanumériques et des tirets bas'
        ]);

        self::generateTranslation('hint_admin_email', [
            'en' => 'Double check your email address before continuing',
            'fr' => 'Vérifiez bien votre adresse e-mail avant de continuer'
        ]);

        self::generateTranslation('admin_install_info', [
            'en' => 'All major steps are done, now enter username and password for your admin, by default its username : <strong>admin</strong> | pass : <strong>admin</strong>',
            'fr' => 'Toutes les étapes majeurs sont terminées, à présent saisissez un identifiant et un mot de passe pour votre administrateur, par défaut comme suit identifiant : <strong>admin</strong> | mot de passe : <strong>admin</strong>'
        ]);

        self::generateTranslation('generate', [
            'en' => 'Generate',
            'fr' => 'Générer'
        ]);

        self::generateTranslation('current', [
            'en' => 'Current',
            'fr' => 'Actuel'
        ]);

        self::generateTranslation('website_configuration', [
            'en' => 'Website basic configurations',
            'fr' => 'Configuration'
        ]);

        self::generateTranslation('website_configuration_info', [
            'en' => 'Here you can set basic configuration of your website, you can change them later by going to Admin area > Website Configurations',
            'fr' => 'Vous pouvez paramétrer ici des éléments de base, vous pourrez les changer ultérieurement en allant dans l\'espace d\'administration > Configuration du site web'
        ]);

        self::generateTranslation('website_title', [
            'en' => 'Website title',
            'fr' => 'Titre du site web'
        ]);

        self::generateTranslation('website_title_hint', [
            'en' => 'It\'s your website title and you can change it from admin area',
            'fr' => 'C\'est le titre de votre site web, vous pouvez le changer depuis l\'espace administrateur'
        ]);

        self::generateTranslation('website_slogan', [
            'en' => 'Website Slogan',
            'fr' => ''
        ]);

        self::generateTranslation('website_slogan_hint', [
            'en' => 'It\'s a slogan OF your website, you can change it from admin area',
            'fr' => 'C\'est le slogan de votre site web, vous pouvez le changer depuis l\'espace administrateur'
        ]);

        self::generateTranslation('website_url', [
            'en' => 'Website URL',
            'fr' => 'Url du site web'
        ]);

        self::generateTranslation('website_url_hint', [
            'en' => 'Without trailing slash',
            'fr' => 'Sans le slash de fin'
        ]);

        self::generateTranslation('agreement', [
            'en' => 'Agreement',
            'fr' => 'Accord'
        ]);

        self::generateTranslation('pre_check', [
            'en' => 'Pre check',
            'fr' => 'Vérifications préalables'
        ]);

        self::generateTranslation('permission', [
            'en' => 'Permissions',
            'fr' => 'Autorisations'
        ]);

        self::generateTranslation('database', [
            'en' => 'Database',
            'fr' => 'Base de donnée'
        ]);

        self::generateTranslation('data_import', [
            'en' => 'Data import',
            'fr' => 'Import des données'
        ]);

        self::generateTranslation('finish', [
            'en' => 'Finish',
            'fr' => 'Fin'
        ]);

        self::generateTranslation('continue_admin_area', [
            'en' => 'Continue to Admin Area',
            'fr' => 'Continuer vers l\'espace d\'administration'
        ]);

        self::generateTranslation('continue_to', [
            'en' => 'Continue to',
            'fr' => 'Continuer vers'
        ]);

        self::generateTranslation('successful_install', [
            'en' => 'has been installed successfully !',
            'fr' => 'a été installé avec succès !'
        ]);

        self::generateTranslation('default_language', [
            'en' => 'Default language',
            'fr' => 'Langage par défaut'
        ]);
    }
}