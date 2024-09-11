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
        self::generateTranslation('enable_access_view_video_history', [
            'fr'=>'Autoriser l\'accès à l\'historique des vues',
            'en'=>'Enable access view history'
        ]);
        self::generateTranslation('video_list_view_video_history', [
            'fr'=>'Historique des vues',
            'en'=>'Views history'
        ]);
        self::generateTranslation('view_history', [
            'fr'=>'Voir l\'historique',
            'en'=>'View history'
        ]);
        self::generateTranslation('history', [
            'fr'=>'Historique',
            'en'=>'History'
        ]);

        self::generateConfig('enable_video_view_video_history', 'no');
        self::generateConfig('video_list_view_video_history', '30');
    }
}
