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
       self::generateTranslation('live_statistics', [
           'fr'=>'Statistiques en direct',
           'en'=>'Live statistics'
       ]);

       self::generateTranslation('ongoing_videos_conversions', [
           'fr'=>'Conversions en cours',
           'en'=>'Ongoing videos conversions'
       ]);

       self::generateTranslation('online_users', [
           'fr'=>'Utilisateurs en ligne',
           'en'=>'Online users'
       ]);
    }
}
