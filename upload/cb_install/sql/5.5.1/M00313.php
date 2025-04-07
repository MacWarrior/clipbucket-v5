<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00313 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_theme_change','no');

        self::generateTranslation('enable_theme_change', [
            'fr'=>'Activer le changement de thème',
            'en'=>'Enable theme change'
        ]);

        self::generateTranslation('enable_theme_change_tips', [
            'fr'=>'Disponible uniquement pour les nouveaux thèmes sombre et clair',
            'en'=>'Only available with new light and dark themes'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('users') . ' ADD COLUMN `active_theme` VARCHAR(15) NULL', [
            'table'=>'users'
        ], [
            'table'=>'users',
            'column'=>'active_theme'
        ]);

        self::generateTranslation('option_theme_auto', [
            'fr'=>'Auto',
            'en'=>'Auto'
        ]);

        self::generateTranslation('title_theme_auto', [
            'fr'=>'Suivre le thème du système',
            'en'=>'Follow system theme'
        ]);

        self::generateTranslation('title_theme_x', [
            'fr'=>'Utiliser le thème %s',
            'en'=>'Use %s theme'
        ]);
    }
}
