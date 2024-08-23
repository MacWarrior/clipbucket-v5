<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00113 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('interfaces', [
            'fr' => 'Interfaces',
            'en' => 'Interfaces'
        ]);
        self::generateTranslation('global', [
            'fr' => 'Global',
            'en' => 'Global'
        ]);
        self::generateTranslation('option_default_theme', [
            'fr' => 'Thème par défaut',
            'en' => 'Default theme'
        ]);
        self::generateTranslation('option_default_theme_light_original', [
            'fr' => 'Clair (Original)',
            'en' => 'Light (Original)'
        ]);
        self::generateTranslation('option_default_theme_light', [
            'fr' => 'Clair',
            'en' => 'Light'
        ]);
        self::generateTranslation('option_default_theme_dark', [
            'fr' => 'Sombre',
            'en' => 'Dark'
        ]);
        self::generateTranslation('option_custom_css', [
            'fr' => 'CSS personnalisé',
            'en' => 'Custom CSS'
        ]);

        self::deleteConfig('allow_template_change');
        self::deleteConfig('recently_viewed_limit');

        self::generateConfig('default_theme', '');
        self::generateConfig('custom_css', '');
    }
}
