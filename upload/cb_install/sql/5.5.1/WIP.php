<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class WIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::insertTool('delete_unused_resolution_files', 'AdminTool::deleteUnusedResolutionFile');
        self::generateTranslation('delete_unused_resolution_files_label', [
            'fr'=>'Suppression des résolutions non utilisés',
            'en'=>'Delete unused resolutions'
        ]);

        self::generateTranslation('delete_unused_resolution_files_description', [
            'fr'=>'Supprime les fichiers vidéos des résolutions non utilisées ,lors de la conversion des vidéos',
            'en'=> 'Delete unused resolution\'s videos files for video conversion'
        ]);
    }
}