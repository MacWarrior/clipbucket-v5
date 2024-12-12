<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00144 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('configurations', [
            'fr'=>'Configurations',
            'en'=>'Configurations'
        ]);

        self::generateTranslation('template_editor', [
            'fr'=>'Editeur de thèmes',
            'en'=>'Template editor'
        ]);

        self::generateTranslation('update_logos', [
            'fr'=>'Mise à jour des logos',
            'en'=>'Update logos'
        ]);

        self::generateTranslation('languages_settings', [
            'fr'=>'Configuration des langues',
            'en'=>'Languages settings'
        ]);

        self::generateTranslation('email_template', [
            'fr'=>'Modèle d\'email',
            'en'=>'Email templates'
        ]);

        self::generateTranslation('watermark_settings', [
            'fr'=>'Configuration des filigranes',
            'en'=>'Watermark settings'
        ]);

        self::generateTranslation('user_levels', [
            'fr'=>'Niveaux d\'utilisateur',
            'en'=>'User levels'
        ]);
    }
}
