<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('remember_theater_mode', 'no');

        self::generateTranslation('theater_mode', [
            'fr'=>'Mode cinéma',
            'en'=>'Theater mode'
        ]);
        self::generateTranslation('exit_theater_mode', [
            'fr'=>'Quitter le mode cinéma',
            'en'=>'Exit theater mode'
        ]);
        self::generateTranslation('remember_theater_mode', [
            'fr'=>'Mémoriser le mode cinéma',
            'en'=>'Remember theater mode'
        ]);
        self::generateTranslation('cookie_theater_mode', [
            'fr'=>'Préférence du mode cinéma',
            'en'=>'Theater mode preference'
        ]);
        self::generateTranslation('cookie_description_theater_mode', [
            'fr'=>'Mémorise le dernier mode d’affichage choisi pour le lecteur vidéo.',
            'en'=>'Remembers the last display mode selected for the video player.'
        ]);
    }
}
