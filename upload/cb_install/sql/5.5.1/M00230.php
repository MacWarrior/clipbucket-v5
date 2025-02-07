<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00230 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_hide_uploader_name', 'no');

        self::generateConfig('photo_enable_nsfw_check', 'no');
        self::generateConfig('video_enable_nsfw_check', 'no');
        self::generateConfig('photo_nsfw_check_model', 'nudity+nsfw');
        self::generateConfig('video_nsfw_check_model', 'nudity+nsfw');

        self::alterTable('ALTER TABLE `{tbl_prefix}flags` MODIFY COLUMN `userid` bigint(20) NULL;', [
            'table' => 'flags',
            'column' => 'userid'
        ]);

        self::generateTranslation('option_enable_nsfw_check', [
            'fr' => 'Activer la vérification de contenu mature',
            'en' => 'Enable NSFW Check'
        ]);

        self::generateTranslation('tips_enable_nsfw_check', [
            'fr' => 'Les contenus matures seront reportés et nécessiteront une activation manuelle',
            'en' => 'NSFW detected contents will be flagged and will requiered a manual activation'
        ]);

        self::generateTranslation('tips_powered_by_ai', [
            'fr' => 'Propulsé par l\'IA',
            'en' => 'Powered by AI'
        ]);

        self::generateTranslation('warning_ai_requirements', [
            'fr' => 'Les fonctionnalités IA nécessitent PHP 7.4+ et l\'extension FFI',
            'en' => 'AI features require PHP 7.4+ and FFI extension'
        ]);

        self::generateTranslation('ai_features_disabled', [
            'fr' => 'Les fonctionnalités IA seront désactivées.',
            'en' => 'AI features will be disabled.'
        ]);

        self::generateTranslation('ai_setup_config', [
            'fr' => 'Veuillez utiliser PHP 7.4+ et activer l\'extension FFI ("preload" ne fonctionnera pas).',
            'en' => 'Please use PHP 7.4+ and enable FFI extension ("preload" won\'t work).'
        ]);

        self::generateTranslation('option_nsfw_check_model', [
            'fr' => 'Modèle de vérification de contenu mature',
            'en' => 'NSFW check model'
        ]);

        self::generateTranslation('option_nudity', [
            'fr' => 'Nudité',
            'en' => 'Nudity'
        ]);

        self::generateTranslation('option_nsfw', [
            'fr' => 'Contenu mature',
            'en' => 'NSFW'
        ]);

        self::generateTranslation('option_nudity_nsfw', [
            'fr' => 'Nudité + contenu mature',
            'en' => 'Nudity + NSFW'
        ]);
    }
}