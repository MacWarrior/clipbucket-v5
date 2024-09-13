<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00135 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('enable_access_view_video_history', [
            'fr'=>'Activer l\'accès à l\'historique des vues',
            'en'=>'Enable access to views history'
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

        self::generateConfig('enable_access_view_video_history', 'no');
        self::generateConfig('video_list_view_video_history', '30');

        self::generateTranslation('usr_cmt_del_msg', [
            'fr'=>'Le commentaire a été supprimé'
        ]);
    }
}
