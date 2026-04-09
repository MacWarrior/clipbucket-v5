<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00103 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::updateTranslation('website_configuration_info', [
            'en' => 'Here you can set basic configuration of your website, you can change them later by going to Admin area > Configurations',
            'fr' => 'Vous pouvez paramétrer ici des éléments de base, vous pourrez les changer ultérieurement en allant dans l\'espace d\'administration > Configurations'
        ]);

        self::updateTranslation('channel_doesnt_exists', [
            'en'=>'Channel doesn\'t exists'
        ]);

        self::updateTranslation('thumb_regen_start', [
            'fr'=>'Regénération des vignettes en cours...',
            'en'=>'Ongoing thumbs regeneration...'
        ]);

        self::updateTranslation('video_subtitle_management', [
            'fr'=>'Fichiers sous-titres',
            'en'=>'Subtitle files'
        ]);

        self::updateTranslation('video_file_management', [
            'fr'=>'Fichiers vidéos',
            'en'=>'Video files'
        ]);

        self::updateTranslation('vdo_cat_msg', [
            'en'=>'You may select up to %s categories'
        ]);

        self::updateTranslation('view_channels_desc', [
            'en'=>'Can view channels page'
        ]);

        self::updateTranslation('email_template', [
            'en' => 'Email template'
        ]);

        self::updateTranslation('sexual_content', [
            'fr'=>'Contenu à caractère sexuel'
        ]);

        self::updateTranslation('player_settings', [
            'en' => 'Player',
            'esp' => 'Reproductor',
            'de' => 'Player',
            'pt-BR' => 'Player',
            'fr' => 'Lecteur'
        ]);

        self::updateTranslation('add_to_my_collection', [
            'fr'=>'Ajouter à une collection',
            'en'=>'Add to a collection'
        ]);

        self::updateTranslation('com_manage_subs', [
            'en' => 'Manage channels subscriptions',
            'fr' => 'Gestion des abonnements de chaîne'
        ]);

        self::updateTranslation('assign_default_thumb_description', [
            'fr' => 'Assigne aux collection la vignette par défaut du premier élément de la collection'
        ]);

        self::updateTranslation('acitvation_html_message', [
            'en' => 'Please enter your username and activation code sended by email in order to activate your account.'
        ]);

        self::updateTranslation('email_forgot_password_sended', [
            'en' => 'If this email address is associated with a user account, reset instructions has been sent to it'
        ]);

        self::updateTranslation('ai_setup_config', [
            'fr'=>'Veuillez activer l\'extension FFI (la configuration "preload" ne fonctionnera pas).',
            'en'=>'Please enable FFI extension ("preload" setting won\'t work).'
        ]);

        self::updateTranslation('warning_ai_requirements', [
            'fr'=>'Les fonctionnalités IA nécessitent l\'extension FFI'
            ,'en'=>'AI features require FFI extension'
        ]);

        self::updateTranslation('warning_php_version', [
            'en'=>'Dear admin,<br/> It seems that you are using an old version of PHP (<b>%s</b>). This version won\'t be supported anymore on upcoming <b>%s</b> version.<br/>Please update your PHP version to %s or above <br/><br/>Thank you for using ClipBucketV5 !'
        ]);

        self::updateTranslation('video_is_not_convertable', [
            'fr'=>'La vidéo "%s" ne peut pas être reconvertie',
            'en'=>'Video "%s" cannot be reconverted'
        ]);

        self::updateTranslation('video_is_already_processing', [
            'fr'=>'La vidéo "%s" est déjà en cours de conversion',
            'en'=>'Video "%s" is already processing'
        ]);

        self::updateTranslation('reconversion_started_for_x', [
            'fr'=>'La reconversion de la vidéo "%s" a été lancée',
            'en'=>'Reconversion for video "%s" has been launched'
        ]);

        self::updateTranslation('make_featured', [
            'en'=>'Make featured'
        ]);

        self::updateTranslation('make_unfeatured', [
            'en'=>'Make unfeatured'
        ]);

        self::updateTranslation('user_no_exist_wid_username', [
            'en'=>'User %s does not exist'
        ]);
    }
}
