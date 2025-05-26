<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('reset', [
            'fr'=>'Réinitialiser',
            'en'=>'Reset'
        ]);

        self::generateTranslation('logo_reset', [
            'fr'=>'Le logo a été réinitialisé',
            'en'=>'Logo has been reset'
        ]);

        self::generateTranslation('favicon_reset', [
            'fr'=>'L\'icône du site a été réinitialisé',
            'en'=>'Favicon has been reset'
        ]);

        self::generateConfig('player-logo_name', config('control_bar_logo_url') == 'images/icons/player-logo.png' ? '' : config('control_bar_logo_url'));
        self::deleteConfig('control_bar_logo_url');
    }
}
