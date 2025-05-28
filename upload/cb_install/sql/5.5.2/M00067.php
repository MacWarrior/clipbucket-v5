<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00067 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('overall_statistics', [
            'fr'=>'Statistiques globales',
            'en'=>'Overall Statistics'
        ]);
        self::generateTranslation('user_statistics', [
            'fr'=>'Statistiques utilisateurs',
            'en'=>'User Statistics'
        ]);
        self::generateTranslation('video_statistics', [
            'fr'=>'Statistiques vidéos',
            'en'=>'Video Statistics'
        ]);
        self::generateTranslation('reported', [
            'fr'=>'Signalés',
            'en'=>'Reported'
        ]);
        self::generateTranslation('total', [
            'fr'=>'Total',
            'en'=>'Total'
        ]);
    }
}
