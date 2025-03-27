<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
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
    }
}
