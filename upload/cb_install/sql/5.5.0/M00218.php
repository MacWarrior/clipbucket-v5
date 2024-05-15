<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00218 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'clean_orphan_files_label\', \'clean_orphan_files_description\', \'AdminTool::cleanOrphanFiles\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('clean_orphan_files_label', [
            'en' => 'Delete orphan files',
            'fr' => 'Suppression des fichiers orphelins'
        ]);

        self::generateTranslation('clean_orphan_files_description', [
            'en' => 'Delete videos files, subtitles, thumbs and logs files which are not related to entries in database',
            'fr' => 'Supprime les fichiers de vidéos, de sous-titres, de miniatures et de logs qui ne sont pas liés à une entrée de la base de données'
        ]);

    }
}