<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00055 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_cookie_banner', [
            'fr'=>'Activer le bandeau de cookies',
            'en'=>'Enable cookie banner'
        ]);

        self::generateConfig('enable_cookie_banner','yes');

        self::generateTranslation('cookies', [
            'fr'=>'Cookies',
            'en'=>'Cookies'
        ]);

        self::generateTranslation('accept', [
            'fr'=>'Accepter',
            'en'=>'Accept'
        ]);

        self::generateTranslation('website_uses_cookies', [
            'fr'=>'Ce site utilise des cookies.',
            'en'=>'This website uses cookies.'
        ]);

        self::generateTranslation('necessary_cookies_only', [
            'fr'=>'Pour vous offrir la meilleure expérience, ce site utilise des cookies strictement nécessaires.',
            'en'=>'To ensure the best experience, only strictly necessary cookies are used.'
        ]);

        self::generateTranslation('cookies_and_consent', [
            'fr'=>'Cookies et Consentement',
            'en'=>'Cookies and Consent'
        ]);

        self::generateTranslation('undefined', [
            'fr'=>'Non défini',
            'en'=>'Undefined'
        ]);

        self::generateTranslation('close', [
            'fr'=>'Fermer',
            'en'=>'Close'
        ]);

        self::generateTranslation('cookie_description_quicklist', [
            'fr'=>'Permet la fonctionnalité quicklist',
            'en'=>'Allow quicklist feature'
        ]);

        self::generateTranslation('cookie_description_phpsessid', [
            'fr'=>'Identifiant de session utilisateur',
            'en'=>'User session ID'
        ]);

        self::generateTranslation('cookie_description_lang', [
            'fr'=>'Permet le changement de langue',
            'en'=>'Allow language switch'
        ]);

        self::generateTranslation('cookie_description_theme', [
            'fr'=>'Permet le changement de thème',
            'en'=>'Allow theme switch'
        ]);

        self::generateTranslation('cookie_description_theme_auto', [
            'fr'=>'Permet le changement de thème automatique',
            'en'=>'Allow auto theme switch'
        ]);

        self::generateTranslation('cookie_description_age_restrict', [
            'fr'=>'Permet l\'accès au contenu restreint',
            'en'=>'Allow access to restricted content'
        ]);

        self::generateTranslation('cookie_description_consent', [
            'fr'=>'Permet l\'enregistrement du consentement',
            'en'=>'Allows consent recording'
        ]);

        self::generateTranslation('save_preferences', [
            'fr'=>'Sauvegarder les préférences',
            'en'=>'Save preferences'
        ]);

        self::generateTranslation('cookie_cant_be_disabled', [
            'fr'=>'Ce cookie est nécessaire au bon fonctionnement du site et ne peut donc pas être désactivé',
            'en'=>'This cookie is required for the website to work properly and so can\'t be disabled'
        ]);

        self::generateTranslation('accept_all', [
            'fr'=>'Accepter tout',
            'en'=>'Accept all'
        ]);

        self::generateTranslation('refuse_all_optionnal', [
            'fr'=>'Refuser tous les optionnels',
            'en'=>'Refuse all optionnal'
        ]);

        self::generateTranslation('lifetime', [
            'fr'=>'Durée de vie',
            'en'=>'Lifetime'
        ]);
    }
}
