<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00032 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_video_remove_black_bars', [
            'fr' => 'Supprimer les bandes de letterboxing/pillarboxing intégrées',
            'en' => 'Remove hard-coded letterboxing / pillarboxing'
        ]);

        self::generateTranslation('tips_video_remove_black_bars', [
            'fr' => 'Supprime les bandes noires intégrées dans les vidéos',
            'en' => 'Remove black bars integrated into videos'
        ]);

        self::generateConfig('video_remove_black_bars', 'no');
    }

}
