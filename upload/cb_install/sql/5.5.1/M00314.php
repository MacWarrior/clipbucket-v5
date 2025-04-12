<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00314 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::deleteConfig('player_logo_file');

        self::updateTranslation('player_settings', [
            'en' => 'Player',
            'esp' => 'Reproductor',
            'de' => 'Player',
            'pt-BR' => 'Player',
            'fr' => 'Lecteur'
        ]);
    }
}
