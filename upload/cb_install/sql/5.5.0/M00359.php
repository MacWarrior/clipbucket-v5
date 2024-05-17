<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00359 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'tool_recalcul_video_file_label\', \'tool_recalcul_video_file_description\', \'AdminTool::recalculVideoFile\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('tool_recalcul_video_file_label', [
            'en' => 'Update video files listing',
            'fr' => 'Mise à jour de la liste des fichiers vidéos'
        ]);
        self::generateTranslation('tool_recalcul_video_file_description', [
            'en' => 'Update all videos file list',
            'fr' => 'Met à jour la liste des fichiers vidéos de toutes les vidéos'
        ]);
    }
}