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
        self::generateTranslation('action_logs', [
            'fr' => 'Journaux d\'activité',
            'en' => 'Action logs'
        ]);

        self::generateTranslation('show_x_logs_entries', [
            'fr'=>'Afficher %s lignes de journaux',
            'en'=>'Showing %s logs entries'
        ]);

        self::generateTranslation('show_log_for_x_type', [
            'fr'=>'pour %s',
            'en'=>'for %s'
        ]);
    }
}
