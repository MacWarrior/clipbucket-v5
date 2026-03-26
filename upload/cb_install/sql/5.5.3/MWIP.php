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
        self::insertTool('task_queue_cleaner', 'AdminTool::cleanUpTask', '0 0 1 * *', true);

        self::generateTranslation('task_queue_cleaner_label', [
            'fr'=>'Nettoyage des outils d\'administration',
            'en'=>'Administration tools cleanup'
        ]);

        self::generateTranslation('task_queue_cleaner_description', [
            'fr'=>'Supprime les anciennes tâches, historiques et journaux des outils d\'administration',
            'en'=>'Clean up old administration tools tasks, history and logs'
        ]);
    }
}
