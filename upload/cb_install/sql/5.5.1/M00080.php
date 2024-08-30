<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00080 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::insertTool('delete_unused_resolution_files', 'AdminTool::deleteUnusedResolutionFile');
        self::generateTranslation('delete_unused_resolution_files_label', [
            'fr'=>'Suppression des résolutions désactivées',
            'en'=>'Delete disabled resolutions'
        ]);

        self::generateTranslation('delete_unused_resolution_files_description', [
            'fr'=>'Supprime les fichiers vidéo des résolutions désactivées pour la conversion des vidéos',
            'en'=> 'Delete video\'s resolutions files disabled for video conversion'
        ]);
    }
}